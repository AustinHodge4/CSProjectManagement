<?php
session_start();
    // Include config file

    require_once 'config.php';

     

    // Define variables and initialize with empty values

    $username = $password = $confirm_password = "";

    $username_err = $password_err = $confirm_password_err = "";

     

$user=array(940931255,
940931551,
940931968,
940932150,
940932158,
940933068,
940933438,
940933540,
940933874,
940935104,
940935282,
940935422,
940935768,
940936153,
940936462,
940936896,
940936902,
940937551,
940939425,
940940208,
940940484,
940940600,
940940649,
940940966,
940941172,
940941175,
940941473,
940941487,
940942239,
940942926,
940943615,
940943833,
940944380,
940944748,
940945746,
940945811,
940948881,
940949532,
940949587,
940950425,
940950573,
940950735,
940952463,
940953250,
940953519,
940953988,
940954144,
940954149,
940954529,
940956342,
940956854,
940957664,
940958157,
940958300,
940958318,
940958363,
940959330,
940959951,
940960776,
940962811,
940962861,
940963284,
940964663,
940965690,
940966702,
940967490,
940968851,
940969236,
940969484,
940969830,
940970145,
940970155,
940970487,
940971227,
940971385,
940972463,
940972532,
940972596,
940973073,
940973869,
940974079,
940974460,
940974706,
940976044,
940976250,
940976570,
940976743,
940977021,
940977205,
940977274,
940977562,
940977628,
940977781,
940978273,
940979472,
940982104,
940982260,
940982748,
940983473,
940983614,
940983729,
940984554,
940984859,
940984980,
940985146,
940985385,
940985509,
940986801,
940987263,
940987352,
940987849,
940988779,
940989395,
940989798,
940989986,
940990825,
940991468,
940992447,
940992693,
940992991,
940993098,
940993335,
940993939,
940994041,
940994882,
940994930,
940995215,
940997924,
940999095,
940999258,
900002973,
900012166,
900012874,
900015599,
900017641,
900052287,
900055367,
900067210,
900093307,
900120538,
900130845,
900137804,
900151506,
900195010,
900214415,
900229973,
900231356,
900242713,
900245028,
900256208,
900273474,
900277190,
900278777,
900281162,
900299943,
900309682,
900328556,
900393921,
900400465,
900417760,
900437608,
900437790,
900449548,
900453514,
900467027,
900468818,
900483719,
900539377,
900540387,
900547993,
900562948,
900577488,
900606178,
900609797,
900624214,
900680267,
900682818,
900688231,
900708949,
900718410,
900721084,
900722751,
900740667,
900743585,
900756671,
900764456,
900767810,
900776156,
900792799,
900800397,
900815797,
900823844,
900838273,
900857846,
900873298,
900881538,
900888915,
900896174,
900897365,
900927477,
900945196,
900946742,
900951438,
900955011,
900999249
);
$pass=array(940931255,
940931551,
940931968,
940932150,
940932158,
940933068,
940933438,
940933540,
940933874,
940935104,
940935282,
940935422,
940935768,
940936153,
940936462,
940936896,
940936902,
940937551,
940939425,
940940208,
940940484,
940940600,
940940649,
940940966,
940941172,
940941175,
940941473,
940941487,
940942239,
940942926,
940943615,
940943833,
940944380,
940944748,
940945746,
940945811,
940948881,
940949532,
940949587,
940950425,
940950573,
940950735,
940952463,
940953250,
940953519,
940953988,
940954144,
940954149,
940954529,
940956342,
940956854,
940957664,
940958157,
940958300,
940958318,
940958363,
940959330,
940959951,
940960776,
940962811,
940962861,
940963284,
940964663,
940965690,
940966702,
940967490,
940968851,
940969236,
940969484,
940969830,
940970145,
940970155,
940970487,
940971227,
940971385,
940972463,
940972532,
940972596,
940973073,
940973869,
940974079,
940974460,
940974706,
940976044,
940976250,
940976570,
940976743,
940977021,
940977205,
940977274,
940977562,
940977628,
940977781,
940978273,
940979472,
940982104,
940982260,
940982748,
940983473,
940983614,
940983729,
940984554,
940984859,
940984980,
940985146,
940985385,
940985509,
940986801,
940987263,
940987352,
940987849,
940988779,
940989395,
940989798,
940989986,
940990825,
940991468,
940992447,
940992693,
940992991,
940993098,
940993335,
940993939,
940994041,
940994882,
940994930,
940995215,
940997924,
940999095,
940999258,
900002973,
900012166,
900012874,
900015599,
900017641,
900052287,
900055367,
900067210,
900093307,
900120538,
900130845,
900137804,
900151506,
900195010,
900214415,
900229973,
900231356,
900242713,
900245028,
900256208,
900273474,
900277190,
900278777,
900281162,
900299943,
900309682,
900328556,
900393921,
900400465,
900417760,
900437608,
900437790,
900449548,
900453514,
900467027,
900468818,
900483719,
900539377,
900540387,
900547993,
900562948,
900577488,
900606178,
900609797,
900624214,
900680267,
900682818,
900688231,
900708949,
900718410,
900721084,
900722751,
900740667,
900743585,
900756671,
900764456,
900767810,
900776156,
900792799,
900800397,
900815797,
900823844,
900838273,
900857846,
900873298,
900881538,
900888915,
900896174,
900897365,
900927477,
900945196,
900946742,
900951438,
900955011,
900999249);
        

        // Check input errors before inserting in database

        foreach ($user as $key => $username)
		{

            

            // Prepare an insert statement

            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

             $stmt = mysqli_prepare($link, $sql);

                // Bind variables to the prepared statement as parameters

                mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

				
                // Set parameters

                $param_username = $username;

                $param_password = password_hash($pass[$key], PASSWORD_DEFAULT); // Creates a password hash

                

                mysqli_stmt_execute($stmt);

                // Attempt to execute the prepared statement

                if(mysqli_stmt_execute($stmt))
					echo "1";

            }

             

            // Close statement

            mysqli_stmt_close($stmt);

        

        

        // Close connection

        mysqli_close($link);

    header("location:index.php");

    ?>
   