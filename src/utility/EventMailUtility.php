<?php
/**
 * Created by PhpStorm.
 * User: michele.lafrancesca
 * Date: 24/01/2020
 * Time: 15:49
 */

namespace open20\amos\events\utility;

use open20\amos\admin\models\UserProfile;
use open20\amos\core\user\User;
use open20\amos\core\utilities\Email;
use open20\amos\events\AmosEvents;
use open20\amos\admin\AmosAdmin;
use open20\amos\events\models\EventCalendarsSlots;
use yii\log\Logger;
use Yii;

class EventMailUtility
{

    /**
     * @param $model
     */
    public static function sendEmailSlotBooked($model)
    {
        $to    = [];
        $event = $model->eventCalendars->event;
        $link  = \Yii::$app->params['platform']['backendUrl']."/community/join?id=".$event->community_id."#my-booking";
        if ($model->user) {
            $to[] = $model->user->email;
        }

        $subject = html_entity_decode($event->title." - ".AmosEvents::t('amosevents', "prenotazione confermata"));
        $message = AmosEvents::t('amosevents',
                "La prenotazione dell’appuntamento è andata a buon fine.<br>In caso di impossibilità a partecipare ti chiediamo cortesemente di disdire l’appuntamento direttamente dal tuo calendario.<br>Puoi vedere il tuo calendario accedendo alla <a href='{link}'>community</a>",
                ['link' => $link]);
        $from = self::getFromMail($event);
        self::sendEmailGeneral($from, $to, $subject, $message);
    }

    /**
     * @param $model
     */
    public static function sendEmailSlotUnbooked($model)
    {
        $to    = [];
        $event = $model->eventCalendars->event;
        $link  = \Yii::$app->params['platform']['backendUrl']."/community/join?id=".$event->community_id."#my-booking";
        if ($model->user) {
            $to[] = $model->user->email;
        }

        $subject = html_entity_decode($event->title." - ".AmosEvents::t('amosevents', "prenotazione annullata"));
        $message = AmosEvents::t('amosevents',
                "La cancellazione dell’appuntamento è andata a buon fine.<br>Ti ricordiamo che in qualsiasi momento puoi accedere alla <a href='{link}'>community</a> per verificare nel tuo calendario tutti gli appuntamenti prenotati",
                ['link' => $link]);
        $from = self::getFromMail($event);
        self::sendEmailGeneral($from, $to, $subject, $message);
    }

    /**
     * @param $model EventCalendarsSlots
     */
    public static function sendEmailPartnerSlotBooked($model)
    {
        $to          = [];
        $event       = $model->eventCalendars->event;
        $userPartner = $model->eventCalendars->partnerUser;
        $nomeCognome = '';
        $data        = '';
        $ora         = '';

        $link = \Yii::$app->params['platform']['backendUrl']."/events/event-calendars/view?id=".$model->eventCalendars->id."&url=/community/join?id=".$event->community_id."";
        if ($userPartner) {
            $to[]        = $userPartner->email;
            $nomeCognome = $model->user->userProfile->nomeCognome;
            $data        = \Yii::$app->formatter->asDate($model->date);
            $ora         = \Yii::$app->formatter->asTime($model->hour_start);
        }
        $subject = html_entity_decode($event->title." - ".AmosEvents::t('amosevents', "prenotazione confermata"));
        $message = AmosEvents::t('amosevents',
                "Ti informiamo che <strong>{nomeCognome}</strong> ha prenotato un appuntamento per il {data} alle ore {ore}.",
                [
                'nomeCognome' => $nomeCognome,
                'data' => $data,
                'ore' => $ora,
        ]);
        $message .= AmosEvents::t('amosevents',"<br><br>Informazioni aggiuntive");
        $message .= AmosEvents::t('amosevents',"<br><strong>Cellulare</strong>: ").$model->cellphone;
        $message .= AmosEvents::t('amosevents',"<br><strong>Affilia<ione</strong>: ").$model->affiliation;
        $from = self::getFromMail($event);
        self::sendEmailGeneral($from, $to, $subject, $message);
    }

    /**
     * @param $model EventCalendarsSlots
     */
    public static function sendEmailPartnerSlotUnbooked($model)
    {
        $to          = [];
        $event       = $model->eventCalendars->event;
        $userPartner = $model->eventCalendars->partnerUser;
        $nomeCognome = '';
        $data        = '';
        $ora         = '';

        $link = \Yii::$app->params['platform']['backendUrl']."/events/event-calendars/view?id=".$model->eventCalendars->id."&url=/community/join?id=".$event->community_id."";
        if ($userPartner) {
            $to[]        = $userPartner->email;
            $nomeCognome = $model->user->userProfile->nomeCognome;
            $data        = \Yii::$app->formatter->asDate($model->date);
            $ora         = \Yii::$app->formatter->asTime($model->hour_start);
        }

        $subject = html_entity_decode($event->title." - ".AmosEvents::t('amosevents', "prenotazione annullata"));
        $message = AmosEvents::t('amosevents',
                "Ti informiamo che <strong>{nomeCognome}</strong> ha annullato l’appuntamento del {data} alle ore {ore}.",
                [
                'nomeCognome' => $nomeCognome,
                'data' => $data,
                'ore' => $ora,
        ]);
        $from = self::getFromMail($event);
        self::sendEmailGeneral($from, $to, $subject, $message);
    }

    /**
     * @param $to
     * @param $profile
     * @param $subject
     * @param $message
     * @param array $files
     * @return bool
     */
    public static function sendEmailGeneral($from, $to, $subject, $message, $files = [])
    {
        try {

            

            /** @var \open20\amos\core\utilities\Email $email */
            $email = new Email();
            $email->sendMail($from, $to, $subject, $message, $files);
        } catch (\Exception $ex) {
            \Yii::getLogger()->log($ex->getMessage(), Logger::LEVEL_ERROR);
        }
        return true;
    }

    /**
     * @param UserProfile $model
     * @param string $subject
     * @param string $contentView
     * @param string|null $from
     * @param string|null $layout
     * @param \open20\amos\community\models\Community $community
     * @return bool
     */
    public static function sendCredentialsMail($model, $subject, $contentView, $from = null, $layout = null, $community = null)
    {
        try {
            $model->user->generatePasswordResetToken();
            $model->user->save(false);
            /** @var AmosAdmin $adminModule */
            $adminModule = \Yii::$app->getModule(AmosAdmin::getModuleName());
            if (empty($layout)) {
                $mailModule = Yii::$app->getModule("email");
                if (isset($mailModule)) {
                    $mailModule->defaultLayout = $layout;
                }
            }

            if (empty($subject)) {
                $subjectView = $adminModule->htmlMailSubject;
                $subject     = Email::renderMailPartial($subjectView, ['profile' => $model], $model->user->id);
            }

            $mail = Email::renderMailPartial($contentView, ['profile' => $model, 'community' => $community],
                    $model->user->id);
            return Email::sendMail((empty($from) ? $from : Yii::$app->params['email-assistenza']),
                    [$model->user->email], $subject, $mail, []);
        } catch (\Exception $ex) {
            \Yii::getLogger()->log($ex->getMessage(), \yii\log\Logger::LEVEL_ERROR);
        }
        return false;
    }

    public static function setLayoutMail($layout = null)
    {
        if (!empty($layout)) {
            $mailModule  = Yii::$app->getModule("email");
            if (isset($mailModule)) {
                $mailModule->defaultLayout = $layout;
            }
        }
    }

    protected static function getFromMail($event)
    {
        $from = '';
        if (!empty(trim($event->email_ticket_sender))) {
            $from = $event->email_ticket_sender;
        } else if (isset(Yii::$app->params['adminEmail'])) {
            $from = Yii::$app->params['adminEmail'];
        } else if (isset(Yii::$app->params['email-assistenza'])) {
            $from = Yii::$app->params['email-assistenza'];
        }
        return $from;
    }
}