<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AppendTokenToUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = session('jwt_token');
        $nik = session('nik');
        $role = session('role');
        $dept = session('dept');
        $jabatan = session('jabatan');

        // Lanjutkan request berikutnya
        $response = $next($request);

        if ($token) {
            $content = $response->getContent();

            // Modifikasi href dan action URL
            $updatedContent = preg_replace_callback(
                '/(href=["\']|action=["\'])([^"\']+)(["\'])/',
                function ($matches) use ($token, $nik, $role, $dept, $jabatan) {
                    if (strpos($matches[2], 'token=') === false) {
                        $url = $matches[2];
                        $delimiter = strpos($url, '?') === false ? '?' : '&';

                        $url .= $delimiter . 'token=' . $token;

                        if ($nik) {
                            $url .= '&nik=' . $nik;
                        }

                        if ($role) {
                            $url .= '&role=' . $role;
                        }

                        if ($dept) {
                            $url .= '&dept=' . $dept;
                        }

                        if ($jabatan) {
                            $url .= '&jabatan=' . $jabatan;
                        }

                        return $matches[1] . $url . $matches[3];
                    }
                    return $matches[0];
                },
                $content
            );

            // Perbarui konten respons
            $response->setContent($updatedContent);
        }

        return $response;
    }

}
