@servers(['local' => '127.0.0.1', 'csce' => 'connection@csce.unl.edu'])

@story('deploy')
  maintenance-on
  update-repo
  build-frontend
  run-migrations
  cache
  maintenance-off
@endstory

@task('maintenance-on', ['on' => 'csce'])
  cd public_html/connection-main
  php artisan down
@endtask

@task('maintenance-off', ['on' => 'csce'])
  cd public_html/connection-main
  php artisan up
@endtask

@task('build-frontend', ['on' => 'local'])
  npm ci
  npm run prod
  tar -czf public.tar.gz public
  scp public.tar.gz connection@csce.unl.edu:public_html/connection-main
  rm public.tar.gz
  ssh connection@csce.unl.edu 'cd public_html/connection-main ; rm -rf public ; tar -xzf public.tar.gz ; rm public.tar.gz'
@endtask

@task('update-repo', ['on' => 'csce'])
  cd public_html/connection-main
  git pull origin main
  php composer.phar install --optimize-autoloader --no-dev
@endtask

@task('run-migrations', ['on' => 'csce'])
  cd public_html/connection-main
  php artisan migrate --force
  php artisan scout:import "App\Models\Post"
  php artisan scout:import "App\Models\PostCollection"
@endtask

@task('cache', ['on' => 'csce'])
  cd public_html/connection-main
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  php artisan storage:link
@endtask
