<?php
$data = require __DIR__ . '/../fr/public_pages.php';
$data['shared'] = [
    'nav_home'=>'Home','nav_services'=>'Services','nav_about'=>'About','nav_support'=>'Support','client_area'=>'Client area','open_account'=>'Open an account',
    'first_name'=>'First name','last_name'=>'Last name','email'=>'Email address','phone'=>'Phone','subject'=>'Subject','choose_subject'=>'Choose a subject',
    'subject_support'=>'Customer support','subject_commercial'=>'Account opening','subject_partnership'=>'Partnership','subject_press'=>'Press','subject_other'=>'Other request',
    'message'=>'Message','message_placeholder'=>'Tell us what you need. We will reply with clear, useful information.',
    'privacy_notice'=>'I agree that Zuider Bank S.A may use this information to answer my request.','send_request'=>'Send my request','rights'=>'All rights reserved.',
];
$t = [
    'services_business'=>['Professional account','A professional account built for fast decisions, clean payments and full control.','A clear and secure banking space for daily operations and sensitive decisions.','Create my business account','A strong banking base for your activity.','Build your professional banking base.'],
    'services_international'=>['Cross-border payments','International transfers that are tracked, documented and easy to understand.','Your transfers keep a clear trail before, during and after processing.','Prepare a transfer','Every transfer keeps a clear record.','Send international transfers with more visibility.'],
    'services_treasury'=>['Treasury management','Treasury you can read quickly and manage calmly.','Balance, history, documents and alerts become easier to use.','Manage my treasury','Financial clarity becomes a management advantage.','Turn your account into a control tool.'],
    'services_cards'=>['Payment cards','Modern cards for paying, tracking and justifying expenses.','A serious banking card connected to a clear and secure experience.','Request my card','A card is useful only when it stays controllable.','Give your payments a card that matches your bank.'],
    'about_story'=>['Our story','A bank built to bring clarity back to digital finance.','Zuider Bank S.A modernizes banking without losing seriousness.','Open my space','Trust, clarity and security.','Discover a bank that moves forward with method.'],
    'about_careers'=>['Careers','Build a clearer, safer and more human bank.','We look for people who care about well-built products and responsible decisions.','Send my application','A team that prefers precision to noise.','Want to build a clearer bank?'],
    'about_press'=>['Press and media','Press resources to understand the evolution of Zuider Bank S.A.','Find our positioning, key topics and official information.','Contact press','A digital bank that takes seriousness seriously.','Need reliable press information?'],
    'about_blog'=>['Banking blog','Articles to better understand online banking.','Guides and insights about security, transfers, receipts, cards and treasury.','Open my account','Useful reading for better decisions.','Move from reading to action.'],
    'support_help'=>['Help center','A help center designed to find answers, not to get lost.','Find key answers about accounts, security, transfers and receipts.','Contact support','Short, useful and action-oriented answers.','Need a personalized answer?'],
    'support_contact'=>['Contact us','A banking question deserves a clear answer.','Tell us about support, account, partnership, press or administrative needs.','Write to support','A form designed to speed up handling.','Is your request ready?'],
    'support_security'=>['Banking security','Security should be visible at every step.','Zuider Bank S.A protects access, sensitive operations and verifiable proofs.','Open a secure account','Security designed for real use.','Secure your operations with visible proof.'],
    'support_legal'=>['Legal information','A readable legal framework to use Zuider Bank S.A with confidence.','Essential information about the publisher, site use, data and responsibilities.','Contact Zuider Bank S.A','Compliance starts with understandable information.','A question about legal information?'],
];
foreach ($t as $key => $v) {
    $data['pages'][$key]['eyebrow']=$v[0]; $data['pages'][$key]['title']=$v[1]; $data['pages'][$key]['subtitle']=$v[2];
    $data['pages'][$key]['primary_cta']=$v[3]; $data['pages'][$key]['hero_card_title']=$v[4]; $data['pages'][$key]['cta_title']=$v[5];
}
$localizePublicPages = require __DIR__ . '/../public_pages_localizer.php';
return $localizePublicPages($data, 'en');
