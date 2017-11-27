#!/usr/bin/perl 
use Expect;
use strict;

my $timeout = 10;

my ($port, $username, $password, $ip, $remote_path, $locale_path) = @ARGV;
my $exp = Expect->spawn("rsync -t -e 'ssh2 -p $port' $username\@$ip:$remote_path $locale_path") or die "Can't spawn ssh";
$exp->expect($timeout, 
	[qr/password/ => sub{
			
	}], 
	[qr/Are you sure you want to continue connecting/ => sub {
		$exp->send("yes\r\n");	
		$exp->expect($timeout, '-re' => 'password');
	}],
);
#print "aa\n";
$exp->send("$password\r\n");
$exp->expect($timeout);
$exp->hard_close();
exit($exp->exitstatus());
#$exp->expect($timeout, '-re' => '/Permission denied, please try again/');
#$exp->interact();
