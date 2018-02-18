<?php

$configs = parse_ini_file(WPATH . "core/configs.ini");

use PHPMailer\PHPMailer\PHPMailer;

require 'modules/mailing/vendor/autoload.php';

class Form_Process extends Database {

    public function execute() {
        if ($_POST['action'] == "quote") {
            return $this->addQuote();
        } if ($_POST['action'] == "inquiry") {
            return $this->addMessage();
        } if ($_POST['action'] == "subscription") {
            return $this->addSubscriber();
        }
    }

    public function addSubscriber() {
        $email = $_POST['email'];
        $d_time = date("Y-m-d H:i:s");

        $sql = "INSERT INTO subscriptions(email, d_time) "
                . "VALUES(:email, :d_time)";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("email", $email);
        $stmt->bindValue("d_time", $d_time);
        if ($stmt->execute()) {
            $mail = new PHPMailer;                             // Passing `true` enables exceptions
            $mail->isSendmail();
            //Recipients
            $mail->setFrom($_SESSION["MUsername"], $_SESSION["MUsernameFrom"]);
            $mail->addAddress($email, $name);     // Add a recipient
            $mail->addBCC($_SESSION["MUsername"], $_SESSION["MUsernameFrom"]);
            //Content
            $mail->Subject = 'SUBSCRIPTION CONFIRMATION';
            $mail->isHTML(true);                                 // Set email format to HTML
            $mail->Body = '<b>Email:</b> ' . $email . '<br/>'
                    . '<b>Time:</b> ' . $d_time . '<br/>'
                    . 'Thank you for signing up to our newsletter. We shall keep you posted on customised offers and promotions.<br/><br/><br/>'
                    . 'Emails powered by <a href="https://reflexconcepts.co.ke" title="Reflex Concepts [KE, UG] LTD | Difference, Delivery, Reliability">Reflex Concepts [KE, UG] LTD</a> ';

            $mail->AltBody = 'Your email is loading.';

            if (!$mail->send()) {
                echo '<div class="error-box">
                      <div class="alert alert-warning">Error, please retry. Your inquiry has not been sent!</div>
                      </div>';
            } else {
                echo '<div class="success-box">
                      <div class="alert alert-success">Congratulations. Your inquiry has been sent successfully!</div>
                      </div>';
            }
            return true;
        } else {
            return false;
        }
    }

    public function addMessage() {
        $name = strtoupper($_POST['name']);
        //$phone = "+254" . substr($_POST['phone'], -9);
        $email = $_POST['email'];

        $message = implode(', ', $_POST['message']);

        $d_time = date("Y-m-d H:i:s");

        $sql = "INSERT INTO inquiries(name, email, message, d_time) "
                . "VALUES(:name, :email, :message, :d_time)";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("name", $name);
        //$stmt->bindValue("phone", $phone);
        $stmt->bindValue("email", $email);
        $stmt->bindValue("message", $message);
        $stmt->bindValue("d_time", $d_time);
        if ($stmt->execute()) {
            $mail = new PHPMailer;                             // Passing `true` enables exceptions
            $mail->isSendmail();
            //Recipients
            $mail->setFrom($_SESSION["MUsername"], $_SESSION["MUsernameFrom"]);
            $mail->addAddress($email, $name);     // Add a recipient
            $mail->addBCC($_SESSION["MUsername"], $_SESSION["MUsernameFrom"]);
            //Content
            $mail->Subject = 'Receipt Confirmation';
            $mail->isHTML(true);                                 // Set email format to HTML
            $mail->Body = '<b>Name:</b> <br/>' . $name . '<br/>'
                    . '<b>Contacts:</b> <br/>' . $email . '<br/>'
                    . '<b>Time:</b> <br/>' . $d_time . '<br/>'
                    . '<b>Request Services:</b> <br/>' . $message . '<br/><br/>'
                    .'I will get back to you soonest possible. Thank you for considering my services.'
                    .'<br/><br/><br/>'
                    . 'Emails powered by <a href="https://reflexconcepts.co.ke" title="Reflex Concepts [KE, UG] LTD | Difference, Delivery, Reliability">Reflex Concepts [KE, UG] LTD</a> ';

            $mail->AltBody = 'Your email is loading.';

            if (!$mail->send()) {
                echo '<div class="error-box">
                      <div class="alert alert-warning">'.$_SESSION["Null_Feedback"].'</div>
                      </div>';
            } else {
                echo '<div class="success-box">
                      <div class="alert alert-success">'.$_SESSION["Feedback"].'</div>
                      </div>';
            }
            return true;
        } else {
            return false;
        }
    }

    public function addQuote() {
        $name = strtoupper($_POST['name']);
        $surname = strtoupper($_POST['surname']);
        $category = strtoupper($_POST['category']);
        $city = strtoupper($_POST['city']);
        $country = strtoupper($_POST['country']);
        $phone = "+254" . substr($_POST['phone'], -9);
        $email = $_POST['email'];
        $quote = $_POST['quote'];
        $d_time = date("Y-m-d H:i:s");

        $sql = "INSERT INTO quote_request(name, surname, category, city, country, phone, email, quote, d_time) "
                . "VALUES(:name, :surname, :category, :city, :country, :phone, :email, :quote, :d_time)";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("name", $name);
        $stmt->bindValue("surname", $surname);
        $stmt->bindValue("category", $category);
        $stmt->bindValue("city", $city);
        $stmt->bindValue("country", $country);
        $stmt->bindValue("phone", $phone);
        $stmt->bindValue("email", $email);
        $stmt->bindValue("quote", $quote);
        $stmt->bindValue("d_time", $d_time);
        if ($stmt->execute()) {
            $mail = new PHPMailer;                             // Passing `true` enables exceptions
            $mail->isSendmail();
            //Recipients
            $mail->setFrom($_SESSION["MUsername"], $_SESSION["MUsernameFrom"]);
            $mail->addAddress($email, $name . ' ' . $surname);     // Add a recipient
            $mail->addBCC($_SESSION["MUsername"], $_SESSION["MUsernameFrom"]);
            //Content
            $mail->Subject = 'Quote request on ' . $category;
            $mail->isHTML(true);                                 // Set email format to HTML
            $mail->Body = '<b>Name:</b> ' . $surname . ', ' . $name . '<br/>'
                    . '<b>Residence:</b> ' . $city . ', ' . $country . '<br/>'
                    . '<b>Contacts:</b> ' . $phone . ', ' . $email . '<br/>'
                    . '<b>Time:</b> ' . $d_time . '<br/>'
                    . '<b>Quote Type:</b> ' . $category . '<br/>'
                    . '<b>Request Details:</b> <br/>' . $quote . '<br/><br/><br/>'
                    . 'Emails powered by <a href="https://reflexconcepts.co.ke" title="Reflex Concepts [KE, UG] LTD | Difference, Delivery, Reliability">Reflex Concepts [KE, UG] LTD</a> ';

            $mail->AltBody = 'Your email is loading.';

            if (!$mail->send()) {
                echo '<div class="error-box">
                      <div class="alert alert-warning">'.$_SESSION["Null_Feedback"].'</div>
                      </div>';
            } else {
                echo '<div class="success-box">
                      <div class="alert alert-success">'.$_SESSION["Feedback"].'</div>
                      </div>';
            }
            return true;
        } else {
            return false;
        }
    }

    public function getCategory() {
        $stmt = $this->prepareQuery("SELECT * FROM services_available ORDER BY _id ASC");
        $stmt->execute();
        $currentGroup = null;
        $html = "";
        while ($row = $stmt->fetch()) {
            if (is_null($currentGroup)) {
                $currentGroup = $row['t_category'];
                $html .= "<option value=\"{$row['t_category']}\" selected>{$row['t_category']}</option>";
            } else {
                $html .= "<option value=\"{$row['t_category']}\">{$row['t_category']} </option>";
            }
        }
        if ($html == "")
            $html = "<option value=\"\">No Events Available</option>";
        echo $html;
        return $currentGroup;
    }

    public function getCountry() {
        $stmt = $this->prepareQuery("SELECT * FROM countries ORDER BY c_name ASC");
        $stmt->execute();
        $currentGroup = null;
        $html = "";
        while ($row = $stmt->fetch()) {
            if (is_null($currentGroup)) {
                $currentGroup = $row['c_name'];
                $html .= "<option value=\"{$row['c_name']}\" selected>{$row['c_name']}</option>";
            } else {
                $html .= "<option value=\"{$row['c_name']}\">{$row['c_name']} </option>";
            }
        }
        if ($html == "")
            $html = "<option value=\"\">No Events Available</option>";
        echo $html;
        return $currentGroup;
    }

}
