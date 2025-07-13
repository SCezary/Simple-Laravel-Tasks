import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({mode}) => {
    const env = loadEnv(mode, process.cwd(), '');
    const host = env.APP_URL;

    return {
        plugins: [
            laravel({
                input: [
                    'resources/sass/app.scss',
                    'resources/js/app.js',
                ],
                refresh: true,
            }),
        ],
        server: {
            host: "0.0.0.0",
            port: 5173,
            origin: `${host}:5173`,
            cors: true
        }
    }
});
