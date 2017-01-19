# paste

a simple pastebin hosting page

#### usage
copy `/css/`, `/p/`, and `/paste/` to your webroot.

pastes are saved in `/p/id.txt`, `/p/id+.html`, and `/p/id++.html` where `id` is a random string.

#### config
in addition to enabling php on `/paste/paste.php`, a good nginx conf would have

```
location /paste/ {
    try_files $uri $uri/ $uri.txt /p;
}
location /p/ {
    try_files $uri $uri.txt $uri.html /p/index.html;
}
```

see `/paste/paste.php` for changing the `$save_path` and `$paste_url` for changing paths.

change `/p/index.html` to point to your paste page.

#### todo
remove inline css on `/paste/index.html`