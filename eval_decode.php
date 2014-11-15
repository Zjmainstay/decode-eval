<?php
// Why
/*
Why this project was even started... I bought some code from a developer on rentacoder that I bought full rights
to and he encrypted almost ALL of it so I would be "forced" to use him for future work on the project. Needless to say
I wont be using him again expecially since part of the project requirements were full unobfuscated code.
I found the bulk of this code on the net. I've modified some of it and added instructions
*/
// Use

//Usage: php eval_decode.php full_path_to.php stepDumpFlag overwriteFlag    //default flag is 0
//Usage: php eval_decode.php full_path_to.php                               //default no step dump out
//Usage: php eval_decode.php full_path_to.php 1                             //step by step dump out
//Usage: php eval_decode.php full_path_to.php 0 1                           //no step dump and overwrite original php file

/*
Decode a single file It's best to provide the "Full path" to the file.
php replace.php <FILENAME>.php
Linux/OSX
Decode All Files inside Folder Recursively
$ find . -type f -name "*.php" -exec php replace.php \{} \;
Windows/DOS (Untested)
Decode All Files inside Folder Recursively
for /r %f in (*.php) do php replace.php %f
*/
// TODO
/*
Usabile output without further editing
Check if eval is inside of javascript
 
*/
echo "\nDECODE nested eval() by DEBO Jurgen mod by sjc, 2014.11.15 by Zjmainstay\n\n";
/**
 * check if have eval
 */
function is_nested( $text ) {
    return preg_match( "/eval/", $text );
}

/**
 * run eval and get result string
 */
function denest( $text ) {
    global $stepDumpFlag;    //step by step dump out flag
    $text = preg_replace( "/<\?php|<\?|\?>/", "", $text );
    if ( $stepDumpFlag ) {
        dump( $text, FALSE );
    }
    
    //replace eval result into variable $evalResult
    $text       = preg_replace( "/eval/", "\$evalResult=", $text );
    //get the new eval text after run eval
    $newText   = preg_replace( "/evalResult/", "newText", $text );
    
    //run eval
    $test = eval( $text );
    //connect the new eval text and eval result, then try run eval again until all eval is replace
    $text = $newText . $evalResult;
    
    if ( $stepDumpFlag ) {
        dump( $text, FALSE );
    }
    
    return $text;
}
echo "Loading Dump";
/**
 * result dump out
 */
function dump( $text, $final ) {
    static $counter = 0;
    global $filename_base;
    global $filename_dir;
    global $filename_decode;
    $filename_new = ( $final ) ? ( $filename_decode ) : ( $filename_dir . '/' . $filename_base . "." . sprintf( "%04d", ++$counter ) . ".php" );
    echo "Writing " . $filename_new . "\n";
    $fp = fopen( $filename_new, "w" );
    if( $final ) {
        $text = "<?php\n//" . trim( $text );
    }
    fwrite( $fp, $text );
    fclose( $fp );
}

//Main
echo "Starting...";
$filename_full      = $argv[1];
$stepDumpFlag       = (bool) @$argv[2]; 
$overwriteFlag      = (bool) @$argv[3];

$filename_base      = basename( $filename_full, '.php' );
$filename_dir       = dirname( $filename_full );

//skip this file
if ( strstr( __FILE__, $filename_full ) == TRUE ) {
    die('Cannot Decode This File.....');
}

//overwrite or not
if(!$overwriteFlag) {
    $filename_decode    = $filename_dir . '/' . $filename_base . '.evaldecode.php';
} else {
    $filename_decode    = $filename_full;
}

$content = "";
echo "Using: " . $filename_base . ".php\n";
echo "Read...\n";
$fp = fopen( $filename_full, "r" );
$content = fread( $fp, filesize( $filename_full ) );
fclose( $fp );
echo "Decode...\n";
//run parse eval string until eval is all replace
while ( is_nested( $content ) ) {
    $content = denest( $content );
}
dump( $content, TRUE );