<?php
require_once './Models/Model.php';

class ProfileModel extends Model
{
    public $db;

    public function __construct()
    {
        $this->db = new DbConnect();
    }

    /**
     * Get user details by user ID
     *
     * @param int $userId
     * @return array|null User details or null if not found
     */
    public function getUserDetails($userId)
    {
        $sql = "SELECT id, personal_code, first_name, last_name, role, profile_image
                FROM user 
                WHERE id = ?";
        $result = $this->db->execute($sql, [$userId]);
        return (!empty($result)) ? $result[0] : null;
    }

    /**
     * Update user's profile information
     *
     * @param int $userId
     * @param array $data User data to update
     * @return array Success status and message
     */

    public function updateProfileImage($userId, $file)
    {
        try {
            // Check for errors
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return [
                    'success' => false,
                    'message' => 'File upload error: ' . $this->getUploadErrorMessage($file['error'])
                ];
            }

            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = $file['type'];

            if (!in_array($fileType, $allowedTypes)) {
                return [
                    'success' => false,
                    'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed.'
                ];
            }

            // Validate file size (2MB max)
            $maxSize = 2 * 1024 * 1024; // 2MB in bytes

            if ($file['size'] > $maxSize) {
                return [
                    'success' => false,
                    'message' => 'File is too large. Maximum size is 2MB.'
                ];
            }

            // Create upload directory if it doesn't exist
            $uploadDir = './uploads/profiles/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate unique filename
            $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = 'profile_' . $userId . '_' . time() . '.' . $fileExtension;
            $uploadPath = $uploadDir . $fileName;

            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                // Update user record in database
                $sql = "UPDATE user SET profile_image = ? WHERE id = ?";
                $params = [$uploadPath, $userId];

                $result = $this->db->execute($sql, $params);

                if ($result !== false) {
                    return [
                        'success' => true,
                        'message' => 'Profile image updated successfully',
                        'image_path' => $uploadPath
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => 'Error updating database record'
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to upload file. Please try again.'
                ];
            }
        } catch (Exception $e) {
            error_log("Error updating profile image: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'An error occurred. Please try again.'
            ];
        }
    }

    /**
     * Change user password
     *
     * @param int $userId
     * @param string $currentPassword
     * @param string $newPassword
     * @return array Success status and message
     */

    private function getUploadErrorMessage($errorCode)
    {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return "The uploaded file exceeds the upload_max_filesize directive in php.ini";
            case UPLOAD_ERR_FORM_SIZE:
                return "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
            case UPLOAD_ERR_PARTIAL:
                return "The uploaded file was only partially uploaded";
            case UPLOAD_ERR_NO_FILE:
                return "No file was uploaded";
            case UPLOAD_ERR_NO_TMP_DIR:
                return "Missing a temporary folder";
            case UPLOAD_ERR_CANT_WRITE:
                return "Failed to write file to disk";
            case UPLOAD_ERR_EXTENSION:
                return "A PHP extension stopped the file upload";
            default:
                return "Unknown upload error";
        }
    }
}