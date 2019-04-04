<?php
/**
 * Created by PhpStorm.
 * User: salah
 * Date: 3/28/2017
 * Time: 10:47 PM
 */

namespace SocialProBundle\Transformer;


use Symfony\Component\Form\DataTransformerInterface;

class AttachementsTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        // TODO: Implement transform() method.
    }

    public function reverseTransform($files)
    {
        $attachments = [];
        foreach($files as $file){
            $attachment = new Attachment();
            $attachment->setFile($file);
            $attachments[] = $attachment;
        }
        return $attachments;
    }

}