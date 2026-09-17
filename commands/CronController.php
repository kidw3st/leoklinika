<?
namespace app\commands;

use app\components\base\MailerReal;
use app\components\sms\SmsSenderDigitalDirect;
use app\models\EmailStack;
use app\models\SystemSettings;
use Yii;
use yii\console\Controller;

class CronController extends Controller
{
    public function actionIndex()
    {
        $this->actionSendMail();
    }

    public function actionSendMail() {
        $count = SystemSettings::getParam('adminbase', 'email_send_count', 20);
        $realmailer = MailerReal::mailer();

        $emails = EmailStack::find()->where(['status' => '1'])->orderBy('priority DESC, created_at ASC')->limit($count)->all();
        foreach($emails as $email) {
            $res = $realmailer->compose()
                ->setFrom(json_decode($email->from, true))
                ->setTo(json_decode($email->to, true))
                ->setBcc(json_decode($email->bcc, true))
                ->setSubject($email->title)
                ->setHtmlBody($email->text)
                ->send();

            $email->status = '2';
            if (!$res) $email->status = '3';
            $email->save();
        }
    }
}