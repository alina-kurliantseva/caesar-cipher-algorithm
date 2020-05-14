<!DOCTYPE html>
<html>
    <head>
        <title>Alina Kurliantseva | Caesar Cipher Algorithm</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="PHP, CSS, Adobe Photoshop">
        <meta name="keywords" content="PHP, CSS, Adobe Photoshop">
        <link href="Style.css" rel="stylesheet">
    </head>
    
    <body>
        <?php
            extract($_POST);
            if (isset($btnEncrypt) || isset($btnDecrypt)) {
                $validation = TRUE;
                $errorK = ValidateK($K);
                $errorM = ValidateM($M);
                if ((strlen($errorK) !== 0) || (strlen($errorM) !== 0)) {
                    $validation = FALSE;
                }
                if ($validation) {
                    if (isset($btnEncrypt)) {
                       $cipherText = Encrypt($M, $K);
                    }
                    if (isset($btnDecrypt)) {
                        $plainText = Decrypt($M, $K);
                    }
                }
            }
            if (isset($btnHack)) {
                $validation = TRUE;
                $errorM = ValidateM($M);
                if ((strlen($errorM) !== 0)) {
                    $validation = FALSE;
                }
                if ($validation) {
                    $keys = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25);
                    foreach ($keys as $K) {
                        $hackText .= Decrypt($M, $K) . "<br>";
                    }               
                }
            }  
        ?>
        <h1>Caesar Cipher Algorithm</h1>
        <div class="profileForm text-center">
            <form method="post" action="caesar-cipher-algorithm.php">
                <label>
                    <p>Enter a shift key for Caesar Cipher:</p>
                    <input type="text" name="K" placeholder="0 - 25" value="<?php echo $K; ?>"/>
                </label><br>
                <p class="error"><?php echo $errorK ?></p><br>
                <label>
                    <p>Enter your message:</p>
                    <input type="text" name="M" placeholder="KURLIANTSEVA" value="<?php echo $M; ?>" />
                </label><br>
                <p class="error"><?php echo $errorM ?></p><br>
                <input type="submit" name="btnEncrypt" value="Encrypt" />
                <input type="submit" name="btnDecrypt" value="Decrypt" />
                <input type="submit" name="btnHack" value="Hack" />
                <br><p><?php echo $cipherText ?></p>
                <p><?php echo $plainText ?></p>
                <div><?php echo $hackText ?></div><br>
            </form>
        </div> 
    </body>
</html>

<?php
    function ValidateK($FieldK) {
        $K = trim($FieldK);
        if (strlen($K) === 0) {
            $errorK = "K field can not be blank.";
        } elseif ((!is_numeric($K)) || ($K < 0) || ($K > 25)) {
            $errorK = "K field must be numeric and (0 - 25).";
        } else {
            $errorK = "";
        }
        return $errorK;
    }
    function ValidateM($FieldM) {
        $M = trim($FieldM);
        if (strlen($M) === 0) {
            $errorM = "M field can not be blank.";
        } else {
            $errorM = "";
        }
        return $errorM;    
    }
    function Cipher($char, $FieldK) {
        if (!ctype_alpha($char)) {
           return $char; 
        }
        $offset = ord(ctype_upper($char) ? 'A' : 'a'); // A - 65, a - 97
        return chr(fmod(((ord($char) + $FieldK) - $offset), 26) + $offset);
    }
    function Encrypt($FieldM, $FieldK)
    {
        $output = "";
        $inputArr = str_split($FieldM);
        foreach ($inputArr as $char) {
            $output .= Cipher($char, $FieldK);
        }   
        return $output;
    }
    function Decrypt($FieldM, $FieldK)
    {
        return Encrypt($FieldM, 26 - $FieldK);
    }