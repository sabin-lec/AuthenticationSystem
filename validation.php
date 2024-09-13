<?php
class InvalidEmailException extends Exception {
    public function errorMessage() {
        // Error message
        return "Error: '{$this->getMessage()}' is not a valid email address.";
    }
}

function validateEmail($email) {
    // Regular expression for validating email
    $emailPattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

    // Check if the email matches the pattern
    if (!preg_match($emailPattern, $email)) {
        // Throw custom exception if email is invalid
        throw new InvalidEmailException($email);
    }
}
