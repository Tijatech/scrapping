<?php
$servername = "localhost";
$username = "id14786519_ayomadewale";
$password = "Qwerty@1234@";
$db = "id14786519_stackjobs";
$conn = mysqli_connect($servername,$username,$password,$db);

if(!$conn){
    die("Hello, Couldn't connect to database");
}

$beginQuery = "SELECT `begin_scrap` FROM begin_scrap WHERE id = 1 LIMIT 1";
$rsp = mysqli_query($conn, $beginQuery);
$begin = mysqli_fetch_row($rsp)[0];





$begin = 98901;
loopStacks($begin, $conn);

function loopStacks($begin,$conn)
{
    $ends = 0;
    for ($i=0; $i < 10; $i++) {
        $val = $begin + $i;
        $ends = $val;
        $base = "https://remoteok.io/remote-jobs/";
        $url = $base.$val;

        print_r(getJob($url,$conn));
        
    }
    // $beginQuery = "UPDATE begin_scrap SET begin_scrap = $ends WHERE id = 1";
    // mysqli_query($conn, $beginQuery);
}

function getJob($url,$conn)
{
   
            $contents = @file_get_contents($url);
            $job = NULL;
            $regex = '!<h2 itemprop="title">(.*?)</h2>!';
            $companyRegex = '!<h3 itemprop="name">(.*?)</h3>!';
            $descRegex = '!<div class="markdown">(.*?)</div>!';
    
    
            // Job Name
            @preg_match_all($regex,$contents,$name);
            if(isset($name[0][0])){ $job["name"] = strip_tags($name[0][0]); }else{ $job["name"] = ""; }

            // Company Offering the job
            @preg_match_all($companyRegex,$contents,$company);
            if(isset($company[0][0])){ $job["company"] = strip_tags($company[0][0]); }else{$job["company"] = "";}
            
            // Job Description
            @preg_match_all($descRegex,$contents,$desc);
            if(isset($desc[0][0])){$job["description"] =strip_tags($desc[0][0]);}else{$job["description"] = "";}
            

            $jobname = $job['name'];
            $jobcompany = $job["company"];
            $jobdesc = $job["description"];
            
            $jobQuery = "INSERT INTO `jobs` (`id`, `name`, `company`,`description`) 
            VALUES (NULL,'$jobname','$jobcompany','$jobdesc')";
            if($jobname != ''){
                return mysqli_query($conn, $jobQuery);
            }else{
                return;
            }
            
       
    
     

}

?>




