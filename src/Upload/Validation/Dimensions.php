<?php

namespace Upload\Validation;

use Upload\Exception;
use Upload\FileInfoInterface;
use Upload\ValidationInterface;

class Dimensions implements ValidationInterface
{
    /**
     * @var integer
     */
    protected $width;

    /**
     * @var integer
     */
    protected $height;

    /**
     * @param int $expectedWidth
     * @param int $expectedHeight
     */
    function __construct($expectedWidth, $expectedHeight)
    {
        $this->width = $expectedWidth;
        $this->height = $expectedHeight;
    }

    /**
     * @inheritdoc
     */
    public function validate(FileInfoInterface $info)
    {
        $dimensions = $info->getDimensions();
        $filename = $info->getNameWithExtension();
        if (!$dimensions) {
            throw new Exception(sprintf('%s: Tidak dapat mendeteksi file.', $filename));
        }
        if ($dimensions['width'] != $this->width) {
            throw new Exception(
                sprintf(
                    '%s: Panjang gambar(%dpx) tidak cocok dengan persyaratan(%dpx)',
                    $filename,
                    $dimensions['width'],
                    $this->width
                )
            );
        }
        if ($dimensions['height'] != $this->height) {
            throw new Exception(
                sprintf(
                    '%s: Lebar gambar(%dpx) tidak cocok dengan persyaratan(%dpx)',
                    $filename,
                    $dimensions['height'],
                    $this->height
                )
            );
        }
    }
}