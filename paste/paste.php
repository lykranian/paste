<?php
header("Content-Type: text/plain");

// simple php paste service
// requires:
//   php
//   python-pygments (and whatever it requires)

// my nginx config has:
//
//   location /paste/ {
//       try_files $uri $uri/ $uri.txt /p;
//   }
//   location /p/ {
//       try_files $uri $uri.txt $uri.html /p/index.html;
//   }
//
// see /p/index.html for more info

// user variables
$save_path = '/usr/share/nginx/rectilinear.xyz/p/'; 
$web_path  = 'https://rectilinear.xyz/p/';
$paste_url = 'https://rectilinear.xyz/paste/';
// end

$t_paste = mb_substr(trim($_POST['paste'], "\n\r\0\x0B"), 0, 50000);

if(empty($t_paste)){
       header("Location: $paste_url");
}
elseif(!empty($t_paste)) {
    $dupe = true;
    $count = 0;
    while($dupe === true) {
        $id = substr(str_shuffle(MD5(microtime())), 0, 10);
        $t_file = $save_path . $id . '.txt';
        $dupe = file_exists($t_file);
        $count = $count + 1;
        if($count == 200) {
            die('something is seriously wrong with the number generator');
        }
    }

    $l_file = $save_path . $id . '++.html';
    $d_file = $save_path . $id . '+.html';

    touch($t_file);
    touch($l_file);
    touch($d_file);

    $t_paste = preg_replace('~\r\n?~', "\n", $t_paste); // what a shitt
    $t_write = file_put_contents($t_file, $t_paste);

    $ilang = $_POST['ilang']; // get the input lang

    switch ($ilang) {
        case "applescript":
             $lang = "applescript";
             break;
        case "bash":
             $lang = "bash";
             break;
        case "c":
             $lang = "c";
             break;
        case "clojure":
             $lang = "clojure";
             break;
        case "cmake":
             $lang = "cmake";
             break;
        case "cobol":
             $lang = "cobol";
             break;
        case "common lisp":
             $lang = "common-lisp";
             break;
        case "c++":
        case "cpp":
             $lang = "c++";
             break;
        case "csharp":
             $lang = "c#";
             break;
        case "css":
             $lang = "css";
             break;
        case "diff":
             $lang = "diff";
             break;        
        case "django":
             $lang = "django";
             break;        
        case "docker":
             $lang = "docker";
             break;        
        case "elisp":
             $lang = "elisp";
             break;        
        case "fish":
             $lang = "fish";
             break;        
        case "fortran":
             $lang = "fortran";
             break;        
        case "glsl":
             $lang = "glsl";
             break;        
        case "gnuplot":
             $lang = "gnuplot";
             break;        
        case "go":
             $lang = "go";
             break;        
        case "hs":
        case "haskell":
             $lang = "haskell";
             break;        
        case "hexdump":
             $lang = "hexdump";
             break;        
        case "html":
             $lang = "html";
             break;        
        case "cfg":
        case "ini":
             $lang = "ini";
             break;        
        case "irclog":
             $lang = "irc";
             break;        
        case "java":
             $lang = "java";
             break;        
        case "javascript":
        case "js":
             $lang = "javascript";
             break;        
        case "json":
             $lang = "json";
             break;       
        case "latex":
        case "tex":
             $lang = "latex";
             break;        
        case "llvm":
             $lang = "llvm";
             break;        
        case "lua":
             $lang = "lua";
             break;        
        case "make":
             $lang = "make";
             break;        
        case "mathematica":
             $lang = "mathemtica";
             break;        
        case "matlab":
             $lang = "matlab";
             break;
        case "nasm":
             $lang = "nasm";
             break;
        case "nginx":
             $lang = "nginx";
             break;        
        case "numpy":
             $lang = "numpy";
             break;        
        case "objective-c":
             $lang = "objective-c";
             break;        
        case "ocaml":
             $lang = "ocaml";
             break;        
        case "octave":
             $lang = "octave";
             break;        
        case "pacman":
             $lang = "pacman";
             break;        
        case "perl":
             $lang = "perl";
             break;        
        case "perl6":
             $lang = "perl6";
             break;        
        case "php":
             $lang = "php";
             break;        
        case "postgres":
        case "postgresql":
             $lang = "postgres";
             break;        
        case "psql":
             $lang = "psql";
             break;        
        case "python":
             $lang = "python";
             break;        
        case "python3":
             $lang = "python3";
             break;        
        case "racket":
             $lang = "racket";
             break;        
        case "ruby":
             $lang = "ruby";
             break;        
        case "rust":
             $lang = "rust";
             break;        
        case "scala":
             $lang = "scala";
             break;        
        case "scheme":
             $lang = "scheme";
             break;        
        case "sql":
             $lang = "sql";
             break;        
        case "sqlite3":
             $lang = "sqlite3";
             break;        
        case "swift":
             $lang = "swift";
             break;        
        case "vim":
             $lang = "vim";
             break;        
        case "xml":
             $lang = "xml";
             break;        
        case "yaml":
             $lang = "yaml";
             break;        
        default:
             $lang = "text";
             break;
    }

    // format lang for pygmentize
    $pygmentize_lang = "-l $lang";

    // calls pygmentize
    $l_paste = shell_exec("pygmentize -f html -O encoding=utf8,style=lovelace,linenos=table $pygmentize_lang $t_file");
    $d_paste = shell_exec("pygmentize -f html -O encoding=utf8,style=monokai,linenos=table $pygmentize_lang $t_file");

    // what follows is trash
    $l_html = "
<!DOCTYPE html>
<html>
<head>
    <title>xyz paste - $lang</title>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
    <link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"/favicon.ico?pls=pls\" />
    <link href=\"/css/light.css\" rel=\"stylesheet\" type=\"text/css\" />
</head>
<body>
<pre><div class=\"vert\"><a href=\"$web_path$id\" download>$lang</a></div></pre>
";

    $d_html = "
<!DOCTYPE html>
<html>
<head>
    <title>xyz paste - $lang</title>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
    <link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"/favicon.ico?pls=pls\" />
    <link href=\"/css/dark.css\" rel=\"stylesheet\" type=\"text/css\" />
</head>
<body>
<pre><div class=\"vert\"><a href=\"$web_path$id\" download>$lang</a></div></pre>";

    $end_html = "
</body>
</html>
";

    // finally write the html pastes
    $l_write = file_put_contents($l_file, $l_html);
    $l_write = file_put_contents($l_file, $l_paste, FILE_APPEND);
    $l_write = file_put_contents($l_file, $end_html, FILE_APPEND);
    $d_write = file_put_contents($d_file, $d_html);
    $d_write = file_put_contents($d_file, $d_paste, FILE_APPEND);
    $d_write = file_put_contents($d_file, $end_html, FILE_APPEND);

    if($write === false) {
        die('file write error?'); // you screwed something up check permissions
    }
    elseif($lang == 'text') {
        header('Location: ' . $web_path . $id);  // returns plaintext if plaintext
    } else {
        header('Location: ' . $web_path . $id . '+'); // change to '++' if you want
    }                                                 //+ to default to light color theme
}
else {
    die('error?');
}