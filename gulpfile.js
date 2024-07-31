import gulp from 'gulp';
import shell from 'gulp-shell';
import copy from 'gulp-copy';
import { deleteAsync } from 'del';

gulp.task('get-wordpress', shell.task([
  'composer install'
]));

gulp.task('copy-files', function() {
    return gulp.src(['wp/**/*', '!wp/composer.json'])
      .pipe(copy('.', { prefix: 1 }))
  });

gulp.task('clean', function() {
  return deleteAsync([
    'wp',
    'wp-content/themes/twentytwentytwo',
    'wp-content/themes/twentytwentythree',
    'wp-content/themes/twentytwentyfour',
    'wp-content/plugins/akismet',
    'wp-content/plugins/hello.php'
  ], {force: true});
});

gulp.task('db:dump', shell.task([
  'ssh -i ~/Homestead/.vagrant/machines/homestead/virtualbox/private_key vagrant@127.0.0.1 -p 2222 "mysqldump -u root -psecret wordpress-boilerplate | gzip > code/wordpress-boilerplate/db.sql.gz"',
]));

gulp.task('db:import', shell.task([
  'ssh -i ~/Homestead/.vagrant/machines/homestead/virtualbox/private_key vagrant@127.0.0.1 -p 2222 "gunzip < code/wordpress-boilerplate/db.sql.gz | mysql -u root -psecret wordpress-boilerplate"',
]));

gulp.task('default', gulp.series(['get-wordpress','copy-files', 'clean']));