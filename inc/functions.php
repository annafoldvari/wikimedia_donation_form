<?php

require_once DIRNAME(__FILE__) . '/../config.php';

/**
 * Builds main form
 */
function buildForm($details) {
  $output = '<form action="confirmation.php" method="post">';
        
  $output .= '<label for="first_name">First Name:</label>';
  $output .= '<input type="text" required id="first_name" name="first-name" value="'.htmlspecialchars($details['first-name'] ?? '').'">';

  $output .= '<label for="last_name">Last Name:</label>';
  $output .= '<input type="text" required id="last_name" name="last-name" value="'.htmlspecialchars($details['last-name'] ?? '').'">';

  $output .= '<label for="street_address">Street Address:</label>';
  $output .= '<input type="text" required id="street_address" name="street-address" value="'.htmlspecialchars($details['street-address'] ?? '').'">';

  $output .= '<label for="city">City:</label>';
  $output .= '<input type="text" required id="city" name="city" value="'.htmlspecialchars($details['city'] ?? '').'">';

  $output .= '<label for="state">State/Region:</label>';
  $output .= '<input type="text" id="state" name="state" value="'.htmlspecialchars($details['state'] ?? '').'">';

  $output .= '<label for="country">Country:</label>';

  $output .= buildCountrySelect(htmlspecialchars($details['country'] ?? ''));

  $output .= '<label for="postal_code">Postal Code:</label>';
  $output .= '<input type="text" id="postal_code" name="postal-code" value="'.htmlspecialchars($details['postal-code'] ?? '').'">';

  $output .= '<label for="phone_number">Phone Number:</label>';
  $output .= '<input type="tel" id="phone_number" name="phone-number" value="'.htmlspecialchars($details['phone-number'] ?? '').'">';
        
  $output .= '<label for="email">Email:</label>';
  $output .= '<input type="email" id="email" name="email" value="'.htmlspecialchars($details['email'] ?? '').'">';

  $output .= '<label for="preferred_contact">Preferred form of contact:</label>';
  $output .= '<select id="preferred_contact" name="preferred-contact">';
  $output .= '<option value="">Select preferred form of contact</option>';
  $output .= '<option '. ($details['preferred-contact'] == 'phone' ? 'selected ' : '') .'value="phone">Phone</option>';
  $output .= '<option '. ($details['preferred-contact'] == 'email' ? 'selected ' : '') . 'value="email">Email</option>';
  $output .= '</select>';

  $output .= '<label for="preferred_payment">Preferred form of payment:</label>';
  $output .= '<select id="preferred_payment" name="preferred-payment">';
  $output .= '<option value="">Select preferred form of payment</option>';
  $output .= '<option '. ($details['preferred-payment'] == 'usd' ? 'selected ' : '') .'value="usd">USD</option>';
  $output .= '<option '. ($details['preferred-payment'] == 'eur' ? 'selected ' : '') .'value="eur">Euro</option>';
  $output .= '<option '. ($details['preferred-payment'] == 'btc' ? 'selected ' : '') .'value="btc">Bitcoin</option>';
  $output .= '</select>';

  $output .= '<label for="frequency">Frequency of donation:</label>';
  $output .= '<select id="frequency" name="frequency">';
  $output .= '<option value="">Select frequency of donation</option>';
  $output .= '<option '. ($details['frequency'] == 'monthly' ? 'selected ' : '') .'value="monthly">Monthly</option>';
  $output .= '<option '. ($details['frequency'] == 'yearly' ? 'selected ' : '') .'value="yearly">Yearly</option>';
  $output .= '<option '. ($details['frequency'] == 'onetime' ? 'selected ' : '') .'value="onetime">One-time</option>';
  $output .= '</select>  ';

  $output .= '<label for="amount">Amount</label>';
  $output .= '<input type="number" required min="0" step="0.01" id="amount" name="amount" value="'.htmlspecialchars($details['amount'] ?? '0').'"> ';     
      
  $output .= '<label for="comments">Comments:</label>';
  $output .= '<textarea id="comments" name="comments" rows="5" cols="33">';
  $output .= htmlspecialchars($details['comments'] ?? ''); 
  $output .= '</textarea>';

  $output .= '<br/>';

  $output .= '<button type="submit">Review</button>';
      
  $output .= '</form>';

  return $output;
}

/**
 * Build the html select element with countries
 */
function buildCountrySelect($selected) {
  // TODO: Include full list
  $countries = [
    'Afghanistan',
    'Albania',
    'Algeria',
    'Andorra',
    'Angola'
  ];

  $output = '<select id="country" name="country">';
  $output .= '<option value="">Select a country</option>'; 
  foreach($countries as $country) {
    $output .= '<option '. ($selected == $country ? 'selected ' : '') .'value="'.$country.'">'.$country.'</option>';
  }
  $output .= '</select>';

  return $output;
}


/**
 * Build the details section for confirmation to review the entered details 
 */
function buildDetails($details, $yearly_donation) {

  $output = '<h1>Confirm your details</h1>';
  $output .= '<h2>First Name:</h2>';
  $output .= '<span class="first_name">'.htmlspecialchars($details['first-name']).'</span>';
  $output .= '<h2>Last Name:</h2>';
  $output .= '<span>'.htmlspecialchars($details['last-name']).'</span>';
  $output .= '<h2>Street Address:</h2>';
  $output .= '<span>'.htmlspecialchars($details['street-address']).'</span>';
  $output .= '<h2>City:</h2>';
  $output .= '<span>'.htmlspecialchars($details['city']).'</span>';
  $output .= '<h2>State/Region:</h2>';
  $output .= '<span>'.htmlspecialchars($details['state']).'</span>';
  $output .= '<h2>Country:</h2>';
  $output .= '<span>'.htmlspecialchars($details['country']).'</span>';
  $output .= '<h2>Postal Code:</h2>';
  $output .= '<span>'.htmlspecialchars($details['postal-code']).'</span>';
  $output .= '<h2>Phone Number</h2>';
  $output .= '<span>'.htmlspecialchars($details['phone-number']).'</span>';
  $output .= '<h2>Email:</h2>';
  $output .= '<span>'.htmlspecialchars($details['email']).'</span>';
  $output .= '<h2>Preferred form of contact:</h2>';
  $output .= '<span>'.htmlspecialchars($details['preferred-contact']).'</span>';
  $output .= '<h2>Comments:</h2>';
  $output .= '<span>'.htmlspecialchars($details['comments']).'</span>';
  if ($details['frequency'] != 'onetime') {
    $output .= '<h2>Total Projected Yearly Donation:</h2>';
    $output .= '<span class="donation_usd">'.$yearly_donation['dollars'].' USD</span><br/>';

    if ($yearly_donation['eur']) {
      $output .= '<span class="donation_eur">'.$yearly_donation['eur'].' EUR</span>';
    }
    if ($yearly_donation['btc']) {
      $output .= '<span class="donation_btc">'.$yearly_donation['btc'].' Bitcoin</span>';
    }
  } else {
    $output .= '<h2>Donation Amount:</h2>';
    $output .= '<span class="donation">You are donating a one-time amount of ' . $yearly_donation['dollars'] . ' USD';
    if ($details['preferred-payment'] != 'usd') {
      $original_currency = $details['preferred-payment'];
      $output .= ' or ' . $yearly_donation[$original_currency] . " " . ($original_currency == "btc" ? "Bitcoin" : "Euro");
    }
    $output .= '</span><br/>'; 
  }
  
  return $output;
}

/**
 * Calculates and converts if necessary the yearly donation or returns the one-time donation amount 
 */
function calculateYearlyDonation($original_currency, $frequency, $amount) { 
    $amount = floatval($amount);
    $multipler = $frequency == "monthly" ? 12 : 1;

    if ($original_currency != "usd") {
      $rate = calculateRate($original_currency);
      $converted = $amount / $rate;

      $result['dollars'] = number_format($multipler * $converted, 2);
      $result[$original_currency] = number_format($multipler * $amount, 2);  
    } else {
      $result['dollars'] = $multipler * $amount;
    }

    return $result;
}

/**
 * Gets the exchange rate for given currency through an API 
 */
function calculateRate($original_currency) {

  global $config;

  $access_key = $config['access-key'];

  $uri = 'http://api.currencylayer.com/live?access_key='.$access_key.'&currencies='.$original_currency;
  $file_content = file_get_contents($uri);
  $api_response = json_decode($file_content, true);

  $rate = array_values($api_response['quotes'])[0];

  return $rate;
}

/**
 * Builds hidden form for details to send across different pages.
 */
function buildHiddenForm($details, $action, $button_text) {
  $output = '<form action="'.$action.'" method="post">';    
  $output .= '<input type="hidden" name="first-name" value="'.htmlspecialchars($details['first-name']).'">';
  $output .= '<input type="hidden" name="last-name" value="'.htmlspecialchars($details['last-name']).'">';
  $output .= '<input type="hidden" name="street-address" value="'.htmlspecialchars($details['street-address']).'">';
  $output .= '<input type="hidden" name="city" value="'.htmlspecialchars($details['city']).'">';
  $output .= '<input type="hidden" name="state" value="'.htmlspecialchars($details['state']).'">';
  $output .= '<input type="hidden" name="country" value="'.htmlspecialchars($details['country']).'">';
  $output .= '<input type="hidden" name="postal-code" value="'.htmlspecialchars($details['postal-code']).'">';
  $output .= '<input type="hidden" name="phone-number" value="'.htmlspecialchars($details['phone-number']).'">';
  $output .= '<input type="hidden" name="email" value="'.htmlspecialchars($details['email']).'">';
  $output .= '<input type="hidden" name="preferred-contact" value="'.htmlspecialchars($details['preferred-contact']).'">';
  $output .= '<input type="hidden" name="preferred-payment" value="'.htmlspecialchars($details['preferred-payment']).'">';
  $output .= '<input type="hidden" name="frequency" value="'.htmlspecialchars($details['frequency']).'">';
  $output .= '<input type="hidden" name="amount" value="'.htmlspecialchars($details['amount']).'">';
  $output .= '<input type="hidden" name="comments" value="'.htmlspecialchars($details['comments']).'">';
  if ($action == 'confirmation.php') {
    $output .= '<input type="hidden" name="confirmation-message" value="true">';
  }
  $output .= '<button type="submit">'.$button_text.'</button>';
  $output .= '</form>';

  return $output;
}

/**
 * Builds the cancel button section
 */
function buildCancelFunction() {
  $output = '<form action="cancelpage.php">';
  $output .= '<button type="submit">Cancel</button>';
  $output .= '</form>';

  return $output;
}

/**
 * Builds the sucess confirmation message when saving to database is successful
 */
function buildConfirmationMessage() {
  $output = '<h2>Thanks for your donation.Your details have been saved!</h2>';

  return $output;
}


/**
 * Saves details into the database
 */
function saveDetailsInDatabase($details) {
  include 'connection.php';

  $user_id = checkIfPersonExists($details['email']);

  if ($user_id) {
    $sql = 'UPDATE personaldetails 
               SET first_name = :firstname,
                   last_name = :lastname,
                   street_address = :streetaddress,
                   city = :city, state = :state,
                   country = :country,
                   postal_code = :postalcode,
                   phone_number = :phonenumber,
                   email = :email,
                   preferred_contact = :preferredcontact
             WHERE id = :id';
  } else {
    $sql = 'INSERT INTO personaldetails(first_name, last_name, street_address, city,
                                        state, country, postal_code, phone_number,
                                        email, preferred_contact)
                VALUES (:firstname, :lastname, :streetaddress, :city, 
                        :state, :country, :postalcode, :phonenumber,
                        :email, :preferredcontact)';
  }

  try {
    $results = $db->prepare($sql);
    if ($user_id) {
      $results->bindParam(':id', $user_id, PDO::PARAM_INT);
    }
    $results->bindParam(':firstname', $details['first-name'], PDO::PARAM_STR);
    $results->bindParam(':lastname', $details['last-name'], PDO::PARAM_STR);
    $results->bindParam(':streetaddress', $details['street-address'], PDO::PARAM_STR);
    $results->bindParam(':city', $details['city'], PDO::PARAM_STR);
    $results->bindParam(':state', $details['state'], PDO::PARAM_STR);
    $results->bindParam(':country', $details['country'], PDO::PARAM_STR);
    $results->bindParam(':postalcode', $details['postal-code'], PDO::PARAM_STR);
    $results->bindParam(':phonenumber', $details['phone-number'], PDO::PARAM_STR);
    $results->bindParam(':email', $details['email'], PDO::PARAM_STR);
    $results->bindParam(':preferredcontact', $details['preferred-contact'], PDO::PARAM_STR);

    $results->execute();

    if (!$user_id) {
      $user_id = $db->lastInsertId();
    }

    $sql = 'INSERT INTO donations (user_id, currency, frequency, amount, comments) 
                 VALUES (?, ?, ?, ?, ?)';

    $results = $db->prepare($sql);

    $results->bindValue(1, $user_id, PDO::PARAM_INT);
    $results->bindValue(2, $details['preferred-payment'], PDO::PARAM_STR);
    $results->bindValue(3, $details['frequency'], PDO::PARAM_STR);
    $results->bindValue(4, $details['amount'], PDO::PARAM_STR);
    $results->bindValue(5, $details['comments'], PDO::PARAM_STR);
    $results->execute();

  } catch (Exception $e) {
    echo "Error!: " . $e->getMessage() . "<br />";
    return false;
  }
  return true;
}

/**
 * Checks if user with given email address is already in the database
 */
function checkIfPersonExists($email) {
  include 'connection.php';

  $sql = "SELECT id 
            FROM personaldetails 
           WHERE email = ?";

  try {
    $results = $db->prepare($sql);
    $results->bindValue(1, $email, PDO::PARAM_STR);
    $results->execute();

    $user_id = $results->fetch();

    if (!$user_id) {
      return false;
    }

    return $user_id['id'];
  } catch (Exception $e) {
    echo "Error!: " . $e->getMessage() . "<br />";
    return false;
  }

}

/**
 * Builds the error messages if there are form validation problems
 */
function formValidationErrors($details) {
  $error_messages = [];
  $output = '<div class="error_messages">';

  if (!$details['first-name']) {
    $error_messages[] = 'First name cannot be blank!'; 
  }
  if (!$details['last-name']) {
    $error_messages[] = 'Last name cannot be blank!'; 
  }
  if (!$details['street-address']) {
    $error_messages[] = 'Street address cannot be blank!'; 
  }
  if (!$details['city']) {
    $error_messages[] = 'City cannot be blank!'; 
  }
  if (!$details['country']) {
    $error_messages[] = 'Country cannot be blank!'; 
  }
  if (!$details['email']) {
    $error_messages[] = 'Email cannot be blank!'; 
  }
  if (!$details['preferred-contact']) {
    $error_messages[] = 'Preferred form of contact cannot be blank!'; 
  }
  if (!$details['preferred-payment']) {
    $error_messages[] = 'Preferred form of payment cannot be blank!'; 
  }
  if (!$details['frequency']) {
    $error_messages[] = 'Frequency of payment cannot be blank!'; 
  }
  if (!$details['amount']) {
    $error_messages[] = 'Amount of donation cannot be blank!'; 
  }

  if (!$details['phone-number'] && $details['preferred-contact'] == 'phone') {
    $error_messages[] = 'If preferred form of contact is phone, phone number cannot be blank!';
  }

  if ($error_messages) {
    foreach ($error_messages as $error_message) {
      $output .= '<p>'.$error_message.'</p>';
    }

    $output .= '</div>';
    return $output;
  }

  return $false;

}