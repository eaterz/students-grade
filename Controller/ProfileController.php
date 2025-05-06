<?php

require_once './Models/ProfileModel.php';

class ProfileController
{
    public function index()
    {
        if (!Validator::Role()) {
            header("Location: /");
            exit();
        }

        $currentUserId = $_SESSION['user']['id'];
        $model = new ProfileModel();
        $userDetails = $model->getUserDetails($currentUserId);

        include './view/profile.php';
    }

    public function updateImage()
    {
        if (!Validator::Role()) {
            header("Location: /");
            exit();
        }

        $currentUserId = $_SESSION['user']['id'];
        $model = new ProfileModel();

        if (!isset($_FILES['profile_image'])) {
            header('Location: /profile?error=No image uploaded');
            exit;
        }

        $result = $model->updateProfileImage($currentUserId, $_FILES['profile_image']);

        if ($result['success']) {
            $_SESSION['user']['profile_image'] = $result['image_path'];
            header('Location: /profile?success=Profile image updated successfully');
        } else {
            header('Location: /profile?error=' . urlencode($result['message']));
        }
        exit;
    }

    // Removed updateProfile method as per request

}