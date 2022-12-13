<?php

namespace App\Security;

use App\Entity\Logs;
use Doctrine\ORM\EntityManagerInterface;
use Detection\MobileDetect;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserLoginMarking
{
    private string $apiLink = 'https://ipapi.co/';
    private string $apiDataType = '/json/';

    public function __construct(
        private HttpClientInterface $httpClient,
        private EntityManagerInterface $entityManager
    ){}

    public function makeUserLog(UserInterface $user)
    {
        $deviceType = $this->getDeviceType();
        $userAgent = $this->getUserAgent();
        $ipAddress = $this->getIpAddress();
        $moreIpData = $this->getMoreIpAddressData($ipAddress);
        $this->insertLogData($user,$deviceType,$userAgent,$ipAddress,$moreIpData);
    }

    private function getIpAddress():string
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if(!filter_var($ip, FILTER_VALIDATE_IP)) {
            $ip = "unknown";
        }
        return $ip;
    }

    private function getUserAgent():string
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    private function getDeviceType():string
    {
        //TODO remove message from this class
        $detect = new MobileDetect();
        $device = 'computer';
        if ($detect->isMobile()) {
            $device = 'mobile';
        }
        if ($detect->isTablet()) {
            $device = 'tablet';
        }
        return $device;
    }

    private function getMoreIpAddressData(string $ip):array
    {
        $data = [];
        $apiResponse = $this->httpClient->request('GET', $this->apiLink.'79.101.198.8'.$this->apiDataType);
        // TODO change this to $this->apiLink.$ip.$this->apiDataType
        $rawData = $apiResponse->toArray();

        $data['continent'] = $rawData['continent_code'];
        $data['country'] = $rawData['country_name'];
        $data['region'] = $rawData['region'];
        $data['provider'] = $rawData['org'];

        return $data;
    }

    private function insertLogData(UserInterface $user, string $deviceType, string $userAgent, string $ipAddress, array $moreIpData)
    {
        $log = new Logs();
        $log->setUser($user);
        $log->setDeviceType($deviceType);
        $log->setUserAgent($userAgent);
        $log->setIpAddress($ipAddress);
        $log->setContinent($moreIpData['continent']);
        $log->setCountry($moreIpData['country']);
        $log->setRegion($moreIpData['region']);
        $log->setProvider($moreIpData['provider']);

        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }

}