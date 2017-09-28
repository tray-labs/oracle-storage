<?php

namespace TrayLabs\OracleStorage;


use TrayLabs\OracleStorage\Client\HttpClient;
use TrayLabs\OracleStorage\Object\File;
use TrayLabs\OracleStorage\Service\DeleteService;
use TrayLabs\OracleStorage\Service\DownloadService;
use TrayLabs\OracleStorage\Service\MetadataService;
use TrayLabs\OracleStorage\Service\UploadService;


class OracleStorage
{
    /**
     * @var array
     */
    protected $configs = [];
    
    /**
     * @var DownloadService
     */
    protected $downloadService;
    
    /**
     * @var UploadService
     */
    protected $uploadService;
    
    /**
     * @var DeleteService
     */
    protected $deleteService;
    
    /**
     * @var MetadataServices
     */
    protected $metadataService;
    
    /**
     * OracleStorage constructor.
     *
     * @param array $configs
     */
    public function __construct(array $configs)
    {
        $this->client = HttpClient::make($configs);
        $this->downloadService = new DownloadService($this->client, $configs);
        $this->uploadService = new UploadService($this->client, $configs);
        $this->deleteService = new DeleteService($this->client, $configs);
        $this->metadataService = new MetadataService($this->client, $configs);
    }

    /**
     *
     * @param string $objectName
     * @param File $file
     *
     * @return boolean
     */
    public function upload(string $objectName, File $file)
    {
        return $this->uploadService->handle($objectName, $file);
    }
    
    /**
     * Download file from storage with name passed
     *
     * @param string $objectName
     */
    public function download(string $objectName)
    {
        return $this->downloadService->handle($objectName);
    }
    
    /**
     * Method get metadata from oracle storage
     *
     * @param string $objectName
     */
    public function metadata(string $objectName)
    {
        return $this->metadataService->handle($objectName);
    }
    
    /**
     * Method delete the file on oracle storage
     *
     * @param string $objectName
     * @return bool
     */
    public function delete(string $objectName): bool
    {
        return $this->deleteService->handle($objectName);
    }
    
}