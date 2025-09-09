<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DbAuditContext
{
    public function handle($request, Closure $next)
    {
        $id   = Auth::id();
        $name = optional(Auth::user())->name
             ?? optional(Auth::user())->username
             ?? optional(Auth::user())->email
             ?? '';
        $ip   = $request->ip() ?? '';

        // Recorre TODAS las conexiones MySQL definidas
        $conns = [];
        foreach (config('database.connections') as $nameConn => $cfg) {
            if (($cfg['driver'] ?? null) === 'mysql') {
                $conns[] = $nameConn;
            }
        }
        if (empty($conns)) {
            $conns[] = config('database.default', 'mysql');
        }

        foreach ($conns as $nameConn) {
            $conn = DB::connection($nameConn);

            // Fuerza abrir la conexión de escritura
            $pdoW = $conn->getPdo();

            // Setea variables en la sesión de escritura
            $pdoW->exec('SET @app_user_id = '.(is_null($id) ? 'NULL' : (int)$id));
            $pdoW->exec('SET @app_user_name = '.$pdoW->quote($name));
            $pdoW->exec('SET @app_ip = '.$pdoW->quote($ip));

            // Si existe conexión de lectura, setea por las dudas
            if (method_exists($conn, 'getReadPdo')) {
                try {
                    $pdoR = $conn->getReadPdo();
                    if ($pdoR) {
                        $pdoR->exec('SET @app_user_id = '.(is_null($id) ? 'NULL' : (int)$id));
                        $pdoR->exec('SET @app_user_name = '.$pdoR->quote($name));
                        $pdoR->exec('SET @app_ip = '.$pdoR->quote($ip));
                    }
                } catch (\Throwable $e) { /* ignore */ }
            }

            // Log opcional para ver la sesión usada
            try {
                $cid = $pdoW->query('SELECT CONNECTION_ID()')->fetchColumn();
                Log::debug('audit ctx set', ['conn' => $nameConn, 'cid' => $cid, 'uid' => $id, 'name' => $name]);
            } catch (\Throwable $e) {}
        }

        return $next($request);
    }
}
