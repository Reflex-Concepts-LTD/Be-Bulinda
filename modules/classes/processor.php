<?php

$configs = parse_ini_file(WPATH . "core/configs.ini");

require 'modules/mailing/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

class Form_Process extends Database {

    public function execute() {
        if ($_POST['action'] == "quote") {
            return $this->addQuote();
        } if ($_POST['action'] == "inquiry") {
            return $this->testMessage();
        } if ($_POST['action'] == "subscription") {
            return $this->addSubscriber();
        }
    }

    public function testMessage() {

        //Server settings
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.zoho.com; smtp.be.co.ke';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'binary@be.co.ke';                 // SMTP username
        $mail->Password = 'damaris1608';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to
        //Recipients
        $mail->setFrom('binary@be.co.ke', 'Mailer');
        $mail->addAddress('bellarmine16@gmail.com', 'Joe Trying');     // Add a recipient
        //
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        if (!$mail->send()) {
            echo "<script>
                iziToast.error({
                    title: 'Oops!',
                    theme: 'dark',
                    message: 'Error, please retry. Not been sent!',
                    position: 'topRight',
                    overlay: 'true',
                    timeout: 10000
                });
            </script>";
        } else {
            echo "<script>
                iziToast.success({
                    title: 'Perfect!',
                    theme: 'dark',
                    message: 'Inquiry sent!',
                    position: 'topRight',
                    overlay: 'true',
                    timeout: 10000
                });
            </script>";
        }
    }

    public function addMessage1() {
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
            $mail = new PHPMailer(true);
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $_SESSION["mail_host"];                   // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $_SESSION["MUsername"];                 // SMTP username
            $mail->Password = $_SESSION["MPassword"];                           // SMTP password
            $mail->SMTPSecure = $_SESSION["SMTPSecure"];                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $_SESSION["Port"];
            //Recipients
            $mail->setFrom($_SESSION["MUsername"], $_SESSION["MUsernameFrom"]);
            $mail->addAddress($email, $name);     // Add a recipient
            $mail->Subject = 'Receipt Confirmation';
            $mail->isHTML(true);                                 // Set email format to HTML
            $information = array($name, $email, $message, $d_time);
            $replace_information = array('%name%', '%email%', '%message%', '%d_time%');

            $content = str_replace($replace_information, $information, file_get_contents('modules/mailing/mail_template.html'));
            $mail->msgHTML($content, dirname(__FILE__));
            $mail->AltBody = 'Your email is loading.';
            if (!$mail->send()) {
            echo "Done";
        } else {
            echo "Done Not";
        }
            return $this->addMessageAdmin();
        } else {
            return false;
        }
    }

    public function addMessageClone() {
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
            //Server settings
            $mail = new PHPMailer(true);
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $_SESSION["mail_host"];  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $_SESSION["MUsername"];                 // SMTP username
            $mail->Password = $_SESSION["MPassword"];                           // SMTP password
            $mail->SMTPSecure = $_SESSION["SMTPSecure"];                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $_SESSION["Port"];
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
                    . '<br/><br/><br/>'
                    . 'Emails powered by <a href="https://reflexconcepts.co.ke" title="Reflex Concepts [KE, UG] LTD | Difference, Delivery, Reliability">Reflex Concepts [KE, UG] LTD</a> ';
            $mail->AltBody = 'Your email is loading.';

            if (!$mail->send()) {
                echo '<div class="error-box">
                      <div class="alert alert-warning">' . $_SESSION["Null_Feedback"] . '</div>
                      </div>';
            } else {
                echo '<div class="success-box">
                      <div class="alert alert-success">' . $_SESSION["Feedback"] . '</div>
                      </div>';
            }
            return true;
        } else {
            return false;
        }
    }

    public function addMessageAdmin() {
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
            $mail = new PHPMailer(true);
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $_SESSION["mail_host"];  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $_SESSION["MUsername"];                 // SMTP username
            $mail->Password = $_SESSION["MPassword"];                           // SMTP password
            $mail->SMTPSecure = $_SESSION["SMTPSecure"];                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $_SESSION["Port"];
            //Recipients
            $mail->setFrom($_SESSION["MUsername"], $_SESSION["MUsernameFrom"]);
            $mail->addAddress($_SESSION["MUsername"], $_SESSION["MUsernameFrom"]);     // Add a recipient
            //$mail->addBCC($_SESSION["MUsername"], $_SESSION["MUsernameFrom"]);
            //Content
            $mail->Subject = 'Service Request from Be Bulinda INC';
            $mail->isHTML(true);                                 // Set email format to HTML
            $mail->Body = '<b>Name:</b> <br/>' . $name . '<br/>'
                    . '<b>Contacts:</b> <br/>' . $email . '<br/>'
                    . '<b>Time:</b> <br/>' . $d_time . '<br/>'
                    . '<b>Request Services:</b> <br/>' . $message . '<br/><br/>'
                    . '<br/><br/><br/>'
                    . 'Emails powered by <a href="https://reflexconcepts.co.ke" title="Reflex Concepts [KE, UG] LTD | Difference, Delivery, Reliability">Reflex Concepts [KE, UG] LTD</a> ';
            $mail->AltBody = 'Your email is loading.';

            $mail->send();
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
                      <div class="alert alert-warning">' . $_SESSION["Null_Feedback"] . '</div>
                      </div>';
            } else {
                echo '<div class="success-box">
                      <div class="alert alert-success">' . $_SESSION["Feedback"] . '</div>
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
