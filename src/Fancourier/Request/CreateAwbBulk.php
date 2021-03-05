<?php

namespace Fancourier\Request;

use Fancourier\Request\Traits\SendsFile;
use Fancourier\Response\CreateAwbBulk as CreateAwbBulkResponse;

/**
 * Class CreateAwb
 * @package Fancourier\Request
 * @SuppressWarnings(PHPMD)
 */
class CreateAwbBulk extends AbstractRequest implements RequestInterface
{
    use SendsFile;

    protected $verb = 'import_awb_integrat.php';

    protected $requests = [];

    public function __construct()
    {
        parent::__construct();
        $this->response = new CreateAwbBulkResponse();
    }

    public function pack()
    {
        if (empty($this->requests)) {
            throw new \Exception("Cannon create AWBs from an empty list");
        }

        //need to write temporary csv
        $file = @tempnam($this->getTempDir(), 'fc' . md5(serialize($this->requests)));

        if (false === $f = fopen($file, 'w')) {
            throw new \Exception("Could not create temporary awb file");
        }

        $writeHeader = true;
        foreach ($this->requests as $request) {
            /** @var CreateAwb $request */
            $data = $request->getData();

            if ($writeHeader) {
                $writeHeader = false;
                fputcsv($f, array_keys($data));
            }

            fputcsv($f, array_values($data));
        }

        fclose($f);
        return $file;
    }

    public function append(CreateAwb $request)
    {
        $this->requests[] = $request;
        return $this;
    }
}
