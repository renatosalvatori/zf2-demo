<?php
/**
 * This file is part of Zf2-demo package
 *
 * @author Rafal Ksiazek <harpcio@gmail.com>
 * @copyright Rafal Ksiazek F.H.U. Studioars
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApplicationFeatureApi\Exception;

use Zend\Http\Response;

class BadRequestException extends AbstractException
{
    public function __construct($message = 'Bad Request', $code = Response::STATUS_CODE_400, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}