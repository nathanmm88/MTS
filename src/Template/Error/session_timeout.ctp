<?php echo $this->element('Error/error',[
    'error' => 'Your session has timed out',
    'errorMessage' => 'For security reasons we limit the session time. Please use the link below to restart your order.'
]); ?>