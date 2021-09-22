<?php

class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function register()
    {

        $data = [
            'username' => '',
            'email' => '',
            'password' => '',
            'confirmPassword' => '',
            'usernameError' => '',
            'emailError' => '',
            'passwordError' => '',
            'confirmPasswordError' => ''
        ];
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize data that was sent with post method
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirmPassword' => trim($_POST['confirmPassword']),
                'usernameError' => '',
                'emailError' => '',
                'passwordError' => '',
                'confirmPasswordError' =>''
            ];

            $nameValidation = "/^[a-zA-Z0-9]*$/";
            $passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";

            // validate usernames on letters / numbers
            if(empty($data['username'])) {
                $data['usernameError'] = "Please enter username.";
            }elseif (!preg_match($nameValidation, $data['username'])) {
                $data['usernameError'] = "Username can only contain letters and numbers";
            }elseif ($this->userModel->findUserByUsername($data['username'])) {
                $data['usernameError'] = "This username is already taken.";
            }


            // validate email
            if(empty($data['email'])) {
                $data['emailError'] = "Please enter email address";
            }else if(!filter_var($data['email'] , FILTER_VALIDATE_EMAIL)){
                $data['emailError'] = "Please enter the correct format";
            }else {
                // Check if email exists
                if($this->userModel->findUserByEmail($data['email'])) {
                    $data['emailError'] = "Email is already taken.";
                }
            }

            // validate password on length ans numeric values
            if(empty($data['password'])) {
                $data['passwordError'] = "Password can't be empty.";
            }elseif(strlen($data['password'] <= 6)) {
                $data['passwordError'] = "Password should be at least 7 characters.";
            }elseif(!preg_match($passwordValidation , $data['password'])) {
                $data['passwordError'] = "Password should have at least one numeric value.";
            }

            // Validate confirm password
            if(empty($data['confirmPassword'])) {
                $data['confirmPasswordError'] = "Please enter Confirm Password.";
            }
            elseif($data['confirmPassword'] != $data['password'] ) {
                $data['confirmPasswordError'] = "Passwords do not match. Please try again.";
            }

            //Make sure that errors are empty
            if(empty($data['usernameError']) && empty($data['emailError']) &&
                empty($data['passwordError']) && empty($data['confirmPasswordError'])) {

                // Hash password
                $data['password'] = password_hash($data['password'] , PASSWORD_DEFAULT);

                //Register user from model function
                if($this->userModel->register($data)) {
                    // Redirect to login page
                    header("Location:" . URLROOT. "/public/users/login");
                }else {
                    die("Something went wrong.");
                }
            }
        }

        $this->view('users/register', $data);

    }

    public function login()
    {
        $data = [
            "title" => "Login page",
            "username" => '',
            "password" => "",
            "usernameError" => "",
            "passwordError" => ""
        ];

        // Check for post
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize post data
            $_POST = filter_input_array(INPUT_POST , FILTER_SANITIZE_STRING);

            $data = [
               'username' => trim($_POST['username']),
               'password' => trim($_POST['password']),
               'usernameError' => '',
                'passwordError' => ''
            ];

            // Validate Username
            if(empty($data['username'])) {
                $data['usernameError'] = "Please enter a Username.";
            }

            // Validate Password
            if(empty($data['password'])) {
                $data['passwordError'] = "Please enter a password.";
            }

            // check if all errors are empty
            if(empty($data['usernameError']) && empty($data['passwordError'])) {
                $loggedInUser = $this->userModel->login($data['username'] , $data['password']);

                if($loggedInUser) {
                    $this->createUserSession($loggedInUser);

                }else {
                   $data['passwordError'] = "Password or Username is incorrect. Please try again.";
                    $this->view('users/login' , $data);
                }
            }
        }
        $this->view('users/login' , $data);
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['user_name'] = $user->user_name;
        $_SESSION['user_email'] = $user->user_email;
        header("Location:" . URLROOT . "/public/pages/index");
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        header("Location:" . URLROOT . "/public/users/login");
    }
}