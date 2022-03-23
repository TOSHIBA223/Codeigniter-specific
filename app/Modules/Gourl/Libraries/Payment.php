<?php 
namespace App\Modules\Gourl\Libraries;

class Payment
{
    
    public function payment_process($sdata, $method=NULL){

        $this->session  = \Config\Services::session();
        $this->db       =  db_connect();

        $builder        = $this->db->table('payment_gateway');
        $gateway        = $builder->select('*')->where('identity', $method)->where('status', 1)->get()->getrow();        

        if ($method=='bitcoin') {            

            /********************************
            * GoUrl Cryptocurrency Payment API
            *********************************/
            if ($gateway) {

                $coin = 'bitcoin';
                    
                DEFINE("CRYPTOBOX_PHP_FILES_PATH", site_url('app/Modules/Gourl/Libraries/gourl/lib/'));
                DEFINE("CRYPTOBOX_IMG_FILES_PATH", site_url('app/Modules/Gourl/Libraries/gourl/images/'));
                DEFINE("CRYPTOBOX_JS_FILES_PATH", site_url('app/Modules/Gourl/Libraries/gourl/js/'));
                
                // Change values below
                // --------------------------------------
                DEFINE("CRYPTOBOX_LANGUAGE_HTMLID", "alang");
                DEFINE("CRYPTOBOX_COINS_HTMLID", "acoin");
                DEFINE("CRYPTOBOX_PREFIX_HTMLID", "acrypto_");

                // Open Source Bitcoin Payment Library
                require FCPATH.'app/Modules/Gourl/Libraries/gourl/lib/cryptobox.class.php';
                    
                /*********************************************************/
                /****  PAYMENT BOX CONFIGURATION VARIABLES  ****/
                /********************************************************/
                $paytype = $this->session->get('payment_type');


                $userID                 = $sdata->user_id; 
                $userFormat             = "COOKIE";
                $orderID                = @$paytype.'_'.@$sdata->user_id.'_'.time();
                $amountUSD              = (float)@$sdata->deposit_amount + (float)@$sdata->fees;
                $period                 = "NOEXPIRY";
                $def_language           = "en";
                $data['def_language']   = "en";
                $def_coin               = $coin;
                $data['def_coin']       = $coin;


                $coins = array($coin);
                $data['coins'] = array($coin);

                $pub_val = $gateway->public_key;
                $piv_val = $gateway->private_key;

                $all_keys = array(  $coin => array( "public_key" => $pub_val,  
                                                    "private_key" => $piv_val));
                    
                // Re-test - all gourl public/private keys
                $def_coin = strtolower($def_coin);
                if (!in_array($def_coin, $coins)) $coins[] = $def_coin;  
                foreach($coins as $v)
                {
                    if (!isset($all_keys[$v]["public_key"]) || !isset($all_keys[$v]["private_key"])) die("Please add your public/private keys for '$v' in \$all_keys variable");
                    elseif (!strpos($all_keys[$v]["public_key"], "PUB"))  die("Invalid public key for '$v' in \$all_keys variable");
                    elseif (!strpos($all_keys[$v]["private_key"], "PRV")) die("Invalid private key for '$v' in \$all_keys variable");
                    elseif (strpos(CRYPTOBOX_PRIVATE_KEYS, $all_keys[$v]["private_key"]) === false) 
                            die("Please add your private key for '$v' in variable \$cryptobox_private_keys, file /lib/cryptobox.config.php.");
                }
                
                // Current selected coin by user
                $coinName = cryptobox_selcoin($coins, $def_coin);
                
                // Current Coin public/private keys
                $public_key  = $gateway->public_key;
                $private_key = $gateway->private_key;
                
                /** PAYMENT BOX **/
                $options = array(
                    "public_key"    => $public_key,
                    "private_key"   => $private_key,
                    "webdev_key"    => 'DEV1124G19CFB313A993D68G453342148', 
                    "orderID"       => $orderID,
                    "userID"        => $userID,
                    "userFormat"    => $userFormat,
                    "amount"        => 0,
                    "amountUSD"     => $amountUSD,
                    "period"        => $period,
                    "language"      => $def_language
                );

                // Initialise Payment Class
                $box = new \Cryptobox ($options);
                $data['box'] = $box;
                $data['options'] = $options;

                // coin name
                $coinName   = $box->coin_name();
                $order      = $box->get_json_values();
                $data['order'] = $order;

                $data['coinImageSize']  = 70;
                $data['qrcodeSize']     = 200;
                $data['show_languages'] = false;
                $data['logoimg_path']   = "default";
                $data['resultimg_path'] = "default";
                $data['resultimgSize']  = 250;
                $data['redirect']       = base_url("customer/payment_callback/bitcoin_confirm/".@$order['order']);
                $data['method']         = "ajax";
                $data['debug']          = false;

                // Text above payment box
                $data['custom_text']  = "";

                return $data;

            }else{
            return false;

            }

        }
    }
}