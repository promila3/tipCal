<!DOCTYPE HTML> 
<!--
     Tip Calculator - Code Path Security Pre Work
--> 
<html>
    <head>
        <title> Tip Calculator </title>
        <meta charset="utf-8" />
    </head>
    <body style="width: 100%; height: 100%; background-color: green ">  
		<div style="top: 40%; left: 40%; position: absolute;">
        <div id="main">
            <?php
            // define variables and set to empty values
            $subTotalError = $tipError = "";
            $split = 1;
            $valid = true;
            $subTotal = $tipPercentage = $tip = $total = 0;
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                //check if subtotal exist, if it exist, check if its valid
                if (empty($_POST["subtotal"])) {
                    $subTotalError = "Subtotal is required";
                    $valid = false;
                } else {
                    $subTotal = trim_input($_POST["subtotal"]);
                    //check if the input is a number
                    if (!preg_match("(^[0-9]*\.?[0-9]+$)", $subTotal)) {
                        $subTotalError = "Invalid Subtotal";
                        $subTotal = 0;
                        $valid = false;
                    } else {
                        //else round the subtotal to two decimal places
                        $subTotal = round(trim_input($_POST["subtotal"]), 2);
                    }
                }
                if (empty($_POST["tipPercent"])) {
                    $tipError = "Tip Percentage Required";
                    $valid = false;
                } else {
                    //else round the subtotal to two decimal places
                    $tipPercentage = round(floatval($_POST["tipPercent"]), 2);
                }
            }
            //used to trim the inputs before checking equality
            function trim_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            ?>

            <h2 id="title">Tip Calculator</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">  

                Bill Subtotal: $<input type="text" name="subtotal" value="<?php echo $subTotal; ?>">
                <br>
                <span class="error"><?php echo $subTotalError; ?></span>
                <br><br>
                Tip Percent:
                <br><br>
                <?php
                //if the tip percent is not currently empty, get the current percentage
                if (!empty($_POST["tipPercent"]))
                    $prevTip = $_POST["tipPercent"];
                else
                    $prevTip = 0.15; //set default value to be 15%
                $tips = [10, 15, 20]; //array of tip values
                //for each value of the array, output the radio button
                foreach ($tips as &$tipPercent) {
                    printf("<input type=\"radio\" name=\"tipPercent\" value=\"%0.2f\" %s /> %d%% \t", $tipPercent / 100, (intval($prevTip * 100) == intval($tipPercent)) ? "checked" : "", $tipPercent);
                }
                print "<br>";
                
             
                ?>
                
                
                <br><br>
                <div align="center">
                    <input type="reset" class="button" value="Reset" onclick="reload_page()"/>
                    <input type="submit" class="button" name="submit" value="Submit">  
                </div>  
				<br><br>	
            </form> 
			
            <!-- use javascript to reset the page -->
            <script>
                function reload_page() {
                    window.location = "";
                }
            </script>

            <?php
            if ($valid && !empty($_POST["subtotal"])) {
				
                echo "<div id=\"result\" style=\"border: 5px solid #aaa;\">";
                echo "Tip: $";
                $tip = $subTotal * $tipPercentage;
                echo number_format($tip, 2);
                echo "<br><br>";
                echo "Total: $";
                $total = $subTotal + $tip;
                echo number_format($total, 2);
                echo "<br><br>";
                
                echo "</div>";
            }
            ?>

        </div>
        </div>
	</body>
</html>