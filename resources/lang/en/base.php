<?php

return [
    'validation_error' => 'There was an error with one or more fields in the request.',
    'errors' => [
        'return' => 'Return to Previous Page',
        'home' => 'Go Home',
        '403' => [
            'header' => 'Forbidden',
            'desc' => 'You do not have permission to access this resource on this server.',
        ],
        '404' => [
            'header' => 'File Not Found',
            'desc' => 'We were unable to locate the requested resource on the server.',
        ],
        'installing' => [
            'header' => 'Server Installing',
            'desc' => 'The requested server is still completing the install process. Please check back in a few minutes, you should receive an email as soon as this process is completed.',
        ],
        'suspended' => [
            'header' => 'Server Suspended',
            'desc' => 'This server has been suspended and cannot be accessed.',
        ],
        'maintenance' => [
            'header' => 'Node Under Maintenance',
            'title' => 'Temporarily Unavailable',
            'desc' => 'This node is under maintenance, therefore your server can temporarily not be accessed.',
        ],
        'deploy' => [
            'full' => 'We are sorry but at the moment there is no space left on our servers.',
            'founds' => 'You don\'t have enough founds on your account to start this server.',
        ],
        'billing' => [
            'identity' => 'You need to fill up your billing info before making any payments.',
            'failed' => 'Sorry, your credit union rejected our request.',
        ],
    ],
    'welcome' => [
        'title' => 'Welcome!',
        'description' => 'Welcome to your control panel, you don\'t have any server yet.<br />Click on the bottom right button to create a new one right now.',
    ],
    'deploy' => [
        'title' => 'Choose a Game',
        'game' => 'Deploy :name',
        'change_game' => 'Change Game',
    ],
    'account' => [
        'details_updated' => 'Your account details have been successfully updated.',
        'invalid_password' => 'The password provided for your account was not valid.',
        'update_pass' => 'Update Password',
        'current_password' => 'Current Password',
        'new_password' => 'New Password',
        'new_password_again' => 'Confirm Password',
        'password_help' => 'Passwords must contain at least one uppercase, lowercase, and numeric character and must be at least 8 characters in length.',
        'update_identity' => 'Update Identity',
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'language' => 'Language',
        'username_help' => 'Your username must be unique to your account, and may only contain the following characters: :requirements',
        'update_email' => 'Update Email',
        'new_email' => 'New Email',
    ],
    'billing' => [
        'summary' => [
            'this_month_charges' => 'This Month Charges',
            'account_balance' => 'Account Balance',
        ],
        'unlink' => [
            'heading' => 'Unlink your CreditCard',
            'description' => 'You have currently linked a <b>:brand</b> ending in <b>:last4</b> to your account. This card will be used for montlhy billing.',
            'submit_button' => 'Unlink Now',
        ],
        'link' => [
            'heading' => 'Link your CreditCard',
            'description' => 'If you link your credit card to this website we will charge you monthly for your server when your account balance is lower than 0.',
            'credit_card_info' => 'Credit Card Info',
            'amount' => 'Charge Amount',
            'submit_button' => 'Charge & Link',
        ],
        'charge' => [
            'heading' => 'Add founds with PayPal',
            'description' => 'You can add founds to your wallet without linking a credit card using paypal.',
            'amount' => 'Charge Amount',
            'submit_button' => '<i class="fab fa-paypal mr-1"></i> Pay Now',
        ],
        'info' => [
            'header' => 'Billing Info',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'address' => 'Address',
            'city' => 'City',
            'country' => 'Country',
            'zip' => 'ZIP',
            'submit_button' => 'Save',
        ],
        'invoices' => [
            'heading' => 'Invoices History',
            'amount' => 'Amount',
            'date' => 'Date'
        ]
    ],
    'security' => [
        'active_sessions' => 'Active Sessions',
        '2fa' => 'Two Factor Authentication',
        '2fa_disabled' => '2-Factor Authentication is disabled on your account! You should enable 2FA in order to add an extra level of protection on your account.',
        '2fa_enabled' => '2-Factor Authentication is enabled on this account and will be required in order to login to the panel. If you would like to disable 2FA, simply enter a valid token below and submit the form.',
        'enable_2fa' => 'Enable',
        'disable_2fa' => 'Disable',
        '2fa_qr' => 'Configure 2FA on Your Device',
        '2fa_checkpoint_help' => 'Use the 2FA application on your phone to take a picture of the QR code to the left, or manually enter the code under it. Once you have done so, generate a token and enter it below.',
        '2fa_token_help' => 'Enter the 2FA Token generated by your app (Google Authenticator, Authy, etc.).',
        '2fa_disable_error' => 'The 2FA token provided was not valid. Protection has not been disabled for this account.',
    ],
    'api' => [
        'header' => 'Your API Keys',
        'no_keys' => 'You do not have any keys on your profile yet.<br />Click the bottom right button to create a new one.',
        'create_new' => 'New Key',
        'new' => [
            'title' => 'Create New',
            'description_hint' => 'Enter a brief description of this key that will be useful for reference.',
            'ips_hint' => 'Enter a line delimited list of IPs that are allowed to access the API using this key. CIDR notation is allowed. Leave blank to allow any IP.',
        ]
    ]
];