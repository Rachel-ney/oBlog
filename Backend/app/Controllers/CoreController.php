<?php
namespace oBlogApi\Controllers;
use PDO;
use PHPMailer\PHPMailer\PHPMailer;
use oBlogApi\Utils\Database;
use oBlogApi\Models\Category;
use oBlogApi\Models\Post;

// classe parente des controller
abstract class CoreController 
{
    protected $router;
    protected $salt = 'My.Favorite.Pony.Is:Pinkie-Pie!';
    protected $msgPassword = '';

    public function __construc($router) {
        $this->router = $router;
    }
    // affiche la réponse en JSON
    protected function showJson($data)
    {
        // Autorise l'accès à la ressource depuis n'importe quel autre domaine
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Credentials: true');
        // Dit au navigateur que la réponse est au format JSON
        header('Content-Type: application/json');
        // La réponse en JSON est affichée
        echo json_encode($data);
    }

    protected function notEmptyDatas($array) {

        $asError = false;

        foreach ($array as $currentIndex) 
        {
            // si vide
            if(empty($currentIndex)) 
            {
                $asError = true;
                $this->sendError('Vous ne pouvez pas laisser de champs vide');
                break;
            }
        }
        
        return $asError;
    }

    protected function passwordIntegrity($pass, $passConfirm) {
        $asError = false;
        $regexPass = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[.?!_])/';
        // je vérifie que le mdp et la confirmation du mdp soient identiques
        if ($pass !== $passConfirm) 
        {
            $this->sendError('Le nouveau mot de passe et sa confirmation doivent êtres identiques', true);
            $asError = true;
        }
        // je vérifie que mon mot de passe fasse bien 8 caractère ou plus
        else if (strlen($pass) < 8 )
        {
            $this->sendError('Le mot de passe doit contenir au moins 8 caractères dont une majuscule, une minuscule, un chiffre et un des caractère suivant _ ? . !', true);
            $asError = true;
        }
        // je vérifie que le mot de passe contienne bien maj, min, chiffre et . ou ? ou ! ou _ (1x ou plus)
        else if (!preg_match($regexPass, $pass))
        {
            $this->sendError('Le mot de passe doit contenir au moins 8 caractères dont une majuscule, une minuscule, un chiffre et un des caractère suivant _ ? . !', true);
            $asError = true;
        }
        return $asError;
    }

    protected function addUserInSession($author) {
        $_SESSION['user'] = [
            'id' => $author->getId(),
            'name' => $author->getName(),
            'email' => $author->getEmail()
        ];
    }

    protected function addPostAuthorInSession() {
        
        if (isset($_SESSION['user']) && isset($_SESSION['user']['posts'])) {

            $_SESSION['user']['posts'] = null;
        }

        $allPost = Post::getAllPostBy('author', $_SESSION['user']['id']);

        if(!empty($allPost))
        {
            foreach($allPost as $post)
            {
                $_SESSION['user']['posts'][] = [
                    'id'         => $post->getId(),
                    'title'      => $post->getTitle(),
                    'resume'     => $post->getResume(),
                    'content'    => $post->getContent(),
                    'category'   => [
                        'id'=> $post->getCategoryId(),
                        'name' => $post->getCategoryName()
                    ],
                    'created_at' => $post->getCreatedAt(),
                    'updated_at' => $post->getUpdatedAt()
                ];
            }
        }
    }

    protected function addCategoryInSession() {
        $allCategory = Category::getAll();

        if(!empty($allCategory))
        {
            foreach($allCategory as $category)
            {
                $_SESSION['category'][$category->getId()] = $category->getName();
            }
        }
    }

    protected function sendMail($recipient, $action) {
        if ($action === 'validate')
        {
            // j'assemble mon lien de redirection
            $urlToSend = 'https://rachel-michel.fr/validation?id='.$recipient->getId().'&token='.$recipient->getToken();

            $mailSubject = 'Validation de votre compte oBlog';
            $mailContent = 'Bonjour '.$recipient->getName().', et bienvenue sur oBlog ! <br/> Veuillez cliquer sur ce lien pour valider votre compte: <br/> <a href="'.$urlToSend.'"> Lien vers oBlog </a>';
        }
        else if ($action === 'lostPass')
        {
            $urlToSend = 'https://rachel-michel.fr/reinitialisation-mot-de-passe?id='.$recipient->getId().'&token='.$recipient->getToken();

            $mailSubject = 'Changer de mot de passe';
            $mailContent = 'Bonjour '.$recipient->getName().'<br/> Veuillez cliquer sur ce lien pour changer votre mot de passe oBlog : <br/> <a href="'.$urlToSend.'"> Lien vers oBlog </a>';
        }
        // Envoi d'un mail de confirmation
        $mail = new PHPMailer(true);// true active les exceptions
        //Server settings
        // debbug : 
        //$mail->SMTPDebug = 2; // 1 = Erreurs et messages, 2 = messages seulement
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true; // activer l'authentification
        $mail->Username = 'rachel.oblog@gmail.com'; // mail hote
        $mail->Password = 'your-pass-here'; // pour des raisons de sécurité ce mot de passe n'est pas valide
        $mail->SMTPSecure = 'ssl'; // encryptage
        $mail->Port = 465; // 587 ou 465 (pour google 465 == sécurisé)
    
        //Recipients
        $mail->setFrom('rachel.oblog@gmail.com', 'oBlog');
        $mail->addAddress($recipient->getEmail(), $recipient->getName());
    
        //Content
        $mail->isHTML(true);
        $mail->Subject = $mailSubject ;
        $mail->Body    = $mailContent ;
    
        if(!$mail->Send()) 
        {
            $this->sendError('Une erreur est survenue lors de l\'envoi du mail.');
            return true;
            // debbug : 
            //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }

        return false;
    }

    protected function sendError($message, $password = false) {

        if($password)
        {
            $array_json['msg']['pass'] = $message;
        }
        else 
        {
            $array_json['msg'] = $message;
        }
        $array_json['success'] = false;
        $this->showJson($array_json);
    }

}