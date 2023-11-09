<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registeration System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <?php 
            //echo 'Good Morning';
            // Check if the registration data is comming or not
            if(isset($_GET['registerSubmit'])){
                //echo 'OK';
                //lets recieve the data

              
                
                //1.DB Connection Open
                $conn  = mysqli_connect('localhost',"root",'','flipkart_db');



                //Always filter/Sanitize the incomming data

               $fullname =  mysqli_real_escape_string($conn,$_GET['fullname']);
               $uname =  mysqli_real_escape_string($conn,$_GET['uname']); 
               $pass =  mysqli_real_escape_string($conn,$_GET['pass']);  
               $cpass =  mysqli_real_escape_string($conn,$_GET['cpass']); 
               $email =  mysqli_real_escape_string($conn,$_GET['email']);  
               $dob =  mysqli_real_escape_string($conn,$_GET['dob']); 
               if(isset($_GET['agree'])){
                    $agree =  mysqli_real_escape_string($conn,$_GET['agree']); 
               } 
               
               //check for tnc
               if(isset( $agree) && $agree == 'yes' ){
                    //echo 'Aggree';
                    //check for pass and cpass
                    if($pass == $cpass){
                        //echo 'Match';
                        //check if the username/email already exits

                        $query = "SELECT * FROM users_tbl WHERE username='$uname' OR email='$email'";

                        $result = mysqli_query($conn,$query);

                        //mysqli_num_rows(result);

                        $count =  mysqli_num_rows($result);

                        if($count > 0){
                            // username already exits
                            echo '<script>toastr.error("Username Or Email already exits")</script>';

                        }else{
                            // username not Available

                            //We can procced for registration

                            //2. Build the query
                            $pass = SHA1($pass);
                            $sql = "INSERT INTO users_tbl(`name`,`email`,`password`,`username`,`dob`) VALUES('$fullname','$email','$pass','$uname','$dob')";
                            
                            //3.Execute the query
                            mysqli_query($conn,$sql);

                            //4. Display the result

                            echo '<script> swal("Good job!", "User registered successfully!", "success"); </script>';
                        
                        }

                    }else{
                        //echo '';
                        echo '<script> swal("Password and Confirm Not Match Not Match!", "Password and Confirm Not Match Not Match!", "error"); </script>';
                    }
               } else{
                  // echo 'Not Agree';
                   echo '<script> swal("Please accept the Terms and Conditions!", "Please accept!", "error"); </script>';
               }  

                //2. Build the query
                $query = '';

                //3. Execute the query

                //4. Display the result

                //5. DB Connection CLose
                mysqli_close($conn);

            }/* else{
                echo 'Not OK';
            } */
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" class="w-50 offset-3">
        <h1 class="text-center mt-5">Registeration Form</h1>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="fullname" class="form-control" id="name" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text"></div>
        </div>
        <div class="mb-3">
            <label for="uname" class="form-label">Username</label>
            <input type="text" name="uname" class="form-control" id="uname">
        </div>
        <div class="mb-3">
            <label for="pass" class="form-label">Password</label>
            <input type="password" name="pass" class="form-control" id="pass">
        </div>
        <div class="mb-3">
            <label for="cpass" class="form-label">Confirm Password</label>
            <input type="password" name="cpass" class="form-control" id="cpass">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email">
        </div>
        <div class="mb-3">
            <label for="dob" class="form-label">Date Of Birth</label>
            <input type="date" name="dob" class="form-control" id="dob">
        </div>
        <div class="mb-3 form-check">
            <input name="agree" value="yes" type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Do yo agree to Terms and Condition?</label>
        </div>
        <button type="submit" name="registerSubmit" class="btn btn-primary">Submit</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>