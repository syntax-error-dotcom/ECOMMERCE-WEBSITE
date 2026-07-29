<?php
class AuthController extends Controller
{
    private $userModel;


    public function __construct()
    {
        //checks if session status isn't active, then start session.
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $db = (new Database())->connect();
        $this->userModel = new UserModel($db);
    }

    //GET LOGIN 
    public function loginPage()
    {
        //checks if user is already login, and then checks away
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['role'] === 'admin') {
                header('Location: /admin');
            } else {
                header('Location: /home');
            }
            exit;
        }
        $this->view('auth/login');
    }

    //POST LOGIN - handle login form
    public function login()
    {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        //basic validation
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Please fill in all fields';
            header('Location: /login');
            exit;
        }

        //find user by email
        $user = $this->userModel->findByEmail($email);

        //checks if the user exist and password matches
        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['error'] = 'Invalid email or password';
            header('Location: /login');
            exit;
        }

        //store session
        $_SESSION['user_id']  = $user['user_id'];
        $_SESSION['role']     = $user['role'];
        $_SESSION['name']     = $user['firstName'];

        //correct credentials - store in session
        if ($user['role'] === 'admin') {
            header('Location: /admin');
        } else {
            header('Location: /home');
        }
        exit;
    }

    //SHOWS the registration form
    public function registerPage()
    {
        $this->view('auth/register');
    }


    //handles the registration form 
    public function register()
    {
        $data = [
            'firstName' => trim($_POST['firstName']),
            'lastName' => trim($_POST['lastName']),
            'email' => trim($_POST['email']),
            'username' => trim($_POST['username']),
            'password' => $_POST['password'],
            'contact_no' => trim($_POST['contact_no']),
            'street' => trim($_POST['street']),
            'barangay' => trim($_POST['barangay']),
            'city' => trim($_POST['city'])
        ];

        //checks if this user already existed.
        if ($this->userModel->emailExists($data['email'])) {
            $_SESSION['error'] = 'Email already registered';
            header('Location: /register');
            exit;
        }

        //hash the password before saving
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        //SAVE THE database
        $this->userModel->create($data);


        $_SESSION['success'] = 'Registration successful! Please login.';
        header('Location: /login');
        exit;
    }

    //LOGOUT
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: /login');
        exit;
    }
}
