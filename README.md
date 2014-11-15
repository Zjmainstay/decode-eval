decode-eval
===========

Decode php encoded with eval statements.

##Why
>Why this project was even started...  I bought some code from a developer on rentacoder that I bought full rights
	to and he encrypted almost ALL of it so I would be "forced" to use him for future work on the project.  Needless to say
	I wont be using him again expecially since part of the project requirements were full unobfuscated code.  
	
>I found the bulk of this code on somewhere on the net. I've modified some of it and added instructions.  Please fork this
	if you have any improvements to make to it.  


##Use

>Usage: php eval_decode.php full_path_to.php stepDumpFlag overwriteFlag    //default flag is 0    
>Usage: php eval_decode.php full_path_to.php        //default no step dump out    
>Usage: php eval_decode.php full_path_to.php 1      //step by step dump out    
>Usage: php eval_decode.php full_path_to.php 0 1    //no step dump and overwrite original php file    

>Decode a single file  It's best to provide the "Full path" to the file.
>php eval_decode.php <FILENAME>.php 

>####Linux/OSX
>Decode All Files inside Folder Recursively

>>_$ find . -type f -name "*.php" -exec php eval_decode.php 0 1\{} \;_

>####Windows/DOS (Untested) 
>Decode All Files inside Folder Recursively 
>>_for /r %f in (*.php) do php eval_decode.php %f_

##Demo
>php eval_decode.php demo/evalFile.php

##TODO 
>#####Usabile output without further editing
>#####Check if eval is inside of javascript
