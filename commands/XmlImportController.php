<?php
namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use Yii;
use app\models\Okpd2;

class XmlImportController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($fileName = null)
    {
        if(empty($file))
        {
            $fileName = Yii::getAlias('@app/temp/okpd2.xml');
        }
        if(\file_exists($fileName))
        {
            echo 'Importing '. $fileName . "\n";
            if(Okpd2::importXml($fileName)) {
                $exit = ExitCode::OK;
            } else {
                $message ="Import error\n";
                Yii::error($message);
                $exit = ExitCode::UNSPECIFIED_ERROR;                
            }
        } else {
            $message = 'File ' . $fileName . " not found on the server\n";
            Yii::error($message);
            $exit = ExitCode::OSFILE;            
        }

        return $exit;
    }

    public function actionClear() {
        Okpd2::deleteAll();
    }
}
