<?php
$emailaddresses = array('andre.oliveira@oandre.myinstance.com','oandre@test.com');
$recipEmailClause =  convertEmailaddresses2SQL($emailaddresses);
function convertEmailaddresses2SQL($emailaddresses) {
		global $conf;
		$result = '';
		$emailtuple = '';
		if ( is_array($emailaddresses) && !empty($emailaddresses) ) {
			foreach ( $emailaddresses as $value ) {
				// Append an address to lookup
				$emailtuple .= ( $emailtuple != '' ? ", '$value'" : "'$value'" );
			}
			$result = " recip.email in ($emailtuple) ";
			// Something is wrongured to support recipient delimiters?
			if(!empty($conf['recipient_delimiter']) ) {
				$delimiter = $conf['recipient_delimiter'];
				foreach ( $emailaddresses as $value ) {
					// separate localpart and domain
					list($localpart, $domain) = explode("@", $value);
					// Append any recipient delimited addresses
					$result .= "OR recip.email LIKE '$localpart$delimiter%@$domain' ";
				}
			}
		}
		// Return results within parentheses to isolate OR statements
		print "($result)";
	}
?>
