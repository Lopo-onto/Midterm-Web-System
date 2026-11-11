<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
    }

    protected function hasImageUpload(string $field): bool
    {
        $file = $this->request->getFile($field);

        return $file !== null && $file->getError() !== UPLOAD_ERR_NO_FILE;
    }

    protected function saveDisplayImage(\CodeIgniter\HTTP\Files\UploadedFile $file, string $folder): string
    {
        $directory = FCPATH . 'uploads/' . $folder;

        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            throw new \RuntimeException('Unable to create the image upload directory.');
        }

        $filename = $file->getRandomName();

        if (extension_loaded('gd') || extension_loaded('imagick')) {
            service('image')
                ->withFile($file->getTempName())
                ->resize(1200, 1200, true)
                ->save($directory . DIRECTORY_SEPARATOR . $filename, 85);
        } else {
            $file->move($directory, $filename);
        }

        return $filename;
    }

    protected function deleteDisplayImage(?string $filename, string $folder): void
    {
        if ($filename === null || basename($filename) !== $filename) {
            return;
        }

        $path = FCPATH . 'uploads/' . $folder . DIRECTORY_SEPARATOR . $filename;

        if (is_file($path)) {
            unlink($path);
        }
    }
}
