<?php
namespace zipMoney\Tests;

use zipMoney\Request;
use zipMoney\Exception;
use zipMoney\Configuration;
use zipMoney\Webhook\Webhook;

require_once dirname(__DIR__).'/vendor/autoload.php';

/**
 * @category  ZipMoney
 * @package   ZipMoney_SDK
 * @author    Sagar Bhandari <sagar.bhandari@zipmoney.com.au>
 * @copyright 2015 ZipMoney Payments.
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.zipmoney.com.au/
 */

class WebhookTest extends TestZipMoney
{
    


    public function testWebhookValidSubscription()
    {  

      if(!$this->webhook_endpoint)
        return;

      $ch = curl_init( $this->webhook_endpoint );
      # Setup request to send json via POST.
      $payload =  '{
        "Type" : "SubscriptionConfirmation",
        "MessageId" : "10c67dbc-2300-4217-958e-c3f596fd606e",
        "Token" : "2336412f37fb687f5d51e6e241d44a2cb13621070379f721624f496560c42a79e22f356446e64ecc0eeec0d6ad91994c6375d57453798f2743d35fcda82f8eca3fc7add92548cd8e7f4d99b5a78400e5d34de2b34763c58bc2aedca1fd5bcf2ac59bdd162d292bf5b2884f0fcd4f52d0d0240b6bbe61a5184beeb636d8e52bbc",
        "TopicArn" : "arn:aws:sns:ap-southeast-2:381371729123:NotificationTestSagar",
        "Message" : "You have chosen to subscribe to the topic arn:aws:sns:ap-southeast-2:381371729123:NotificationTestSagar.\nTo confirm the subscription, visit the SubscribeURL included in this message.",
        "SubscribeURL" : "https://sns.ap-southeast-2.amazonaws.com/?Action=ConfirmSubscription&TopicArn=arn:aws:sns:ap-southeast-2:381371729123:NotificationTestSagar&Token=2336412f37fb687f5d51e6e241d44a2cb13621070379f721624f496560c42a79e22f356446e64ecc0eeec0d6ad91994c6375d57453798f2743d35fcda82f8eca3fc7add92548cd8e7f4d99b5a78400e5d34de2b34763c58bc2aedca1fd5bcf2ac59bdd162d292bf5b2884f0fcd4f52d0d0240b6bbe61a5184beeb636d8e52bbc",
        "Timestamp" : "2016-05-04T02:06:17.367Z",
        "SignatureVersion" : "1",
        "Signature" : "RqJlLpU7u0c1yMtVunDuJYfrjxmYOh/z+JB/dbgl7rK69I+It3kHKCozDRfz5bGU8MrIXBeR3CtCKaapt+xuH/8YAWxFZ4ihnp0eiCTnRePZO2+G6o5VbVx00q3qGODQg9R/TSM4oSZPb48vNjFy4F0EQrzMNjaazH5qT7armA8vEEokBbFmBSMoXPYVz27xcewTT3Z3ppqi2nSz9LuAT/RG3WFWOPCW0/6b23VEK3GqlRcSOkxAucAOFHhrwXMAOHEtCIXv+Wr5HcVpMfEuwNZn4gI3GUXN1Ipe2udW1yLpozfZmDHjws8JgNIfccJCmECtwqoF/CcXrXYPVlVSCg==",
        "SigningCertURL" : "https://sns.ap-southeast-2.amazonaws.com/SimpleNotificationService-bb750dd426d95ee9390147a5624348ee.pem"
      }';
      curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
      curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
      $result = curl_exec($ch);
      $status = curl_getinfo($ch,CURLINFO_HTTP_CODE);
      curl_close($ch);
      $this->assertEquals(200,$status);
    } 

    public function testWebhookInValid()
    {
      if(!$this->webhook_endpoint)
        return ;

      $ch = curl_init( $this->webhook_endpoint  );
      # Setup request to send json via POST.
      $payload =  '{
        "Type" : "SubscriptiosnConfirmation",
        "MessageId" : "10c67dbc-2300-4217-958e-c3f596fd606e",
        "Token" : "2336412f37fb687f5d51e6e241d44a2cb13621070379f721624f496560c42a79e22f356446e64ecc0eeec0d6ad91994c6375d57453798f2743d35fcda82f8eca3fc7add92548cd8e7f4d99b5a78400e5d34de2b34763c58bc2aedca1fd5bcf2ac59bdd162d292bf5b2884f0fcd4f52d0d0240b6bbe61a5184beeb636d8e52bbc",
        "TopicArn" : "arn:aws:sns:ap-southeast-2:381371729123:NotificationTestSagar",
        "Message" : "You have chosen to subscribe to the topic arn:aws:sns:ap-southeast-2:381371729123:NotificationTestSagar.\nTo confirm the subscription, visit the SubscribeURL included in this message.",
        "SubscribeURL" : "https://sns.ap-southeast-2.amazonaws.com/?Action=ConfirmSubscription&TopicArn=arn:aws:sns:ap-southeast-2:381371729123:NotificationTestSagar&Token=2336412f37fb687f5d51e6e241d44a2cb13621070379f721624f496560c42a79e22f356446e64ecc0eeec0d6ad91994c6375d57453798f2743d35fcda82f8eca3fc7add92548cd8e7f4d99b5a78400e5d34de2b34763c58bc2aedca1fd5bcf2ac59bdd162d292bf5b2884f0fcd4f52d0d0240b6bbe61a5184beeb636d8e52bbc",
        "Timestamp" : "2016-05-04T02:06:17.367Z",
        "SignatureVersion" : "1",
        "Signature" : "RqJlLpU7u0c1yMtVunDuJYfrjxmYOh/z+JB/dbgl7rK69I+It3kHKCozDRfz5bGU8MrIXBeR3CtCKaapt+xuH/8YAWxFZ4ihnp0eiCTnRePZO2+G6o5VbVx00q3qGODQg9R/TSM4oSZPb48vNjFy4F0EQrzMNjaazH5qT7armA8vEEokBbFmBSMoXPYVz27xcewTT3Z3ppqi2nSz9LuAT/RG3WFWOPCW0/6b23VEK3GqlRcSOkxAucAOFHhrwXMAOHEtCIXv+Wr5HcVpMfEuwNZn4gI3GUXN1Ipe2udW1yLpozfZmDHjws8JgNIfccJCmECtwqoF/CcXrXYPVlVSCg==",
        "SigningCertURL" : "https://sns.ap-southeast-2.amazonaws.com/SimpleNotificationService-bb750dd426d95ee9390147a5624348ee.pem"
      }';
      curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
      curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
      $result = curl_exec($ch);     
      $status = curl_getinfo($ch,CURLINFO_HTTP_CODE); 
      curl_close($ch);
      $this->assertEquals(404,$status);
      $this->assertEquals("Invalid Notification. Cannot validate the signature.",$result);
    }

} 