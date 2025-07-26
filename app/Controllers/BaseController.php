<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['form','auth','url'];

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
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');
    }
    
    /**
     * Auto-check dan update status reservasi yang sudah expired
     * Dipanggil saat ada visitor untuk trigger cleanup otomatis
     * 
     * @return int Jumlah reservasi yang di-expired
     */
    protected function autoCheckExpiredBookings()
    {
        static $lastCheck = 0;
        $now = time();
        
        // Rate limiting: cek maksimal 1x per 30 detik untuk efisiensi
        if (($now - $lastCheck) < 30) {
            return 0;
        }
        $lastCheck = $now;
        
        try {
            $reservasiModel = new \App\Models\Reservasi();
            
            // Cari reservasi online yang expired (lewat batas_waktu)
            $expiredReservations = $reservasiModel
                ->where('status', 'diproses')
                ->where('online', 1)  // Hanya booking online yang punya timer
                ->where('batas_waktu <', date('Y-m-d H:i:s'))
                ->findAll();
            
            $expiredCount = 0;
            foreach ($expiredReservations as $reservation) {
                // Update status ke 'limit' - kamar jadi available lagi
                $reservasiModel->update($reservation['idbooking'], [
                    'status' => 'limit'
                ]);
                $expiredCount++;
                
                // Log untuk monitoring (optional)
                log_message('info', "Auto-expired booking: {$reservation['idbooking']} - 15 minute timeout reached");
            }
            
            return $expiredCount;
            
        } catch (\Exception $e) {
            // Jika ada error, jangan sampai crash aplikasi utama
            log_message('error', 'Error in autoCheckExpiredBookings: ' . $e->getMessage());
            return 0;
        }
    }
}
