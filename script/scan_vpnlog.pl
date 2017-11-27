#!/usr/bin/perl
use strict;
use warnings;

use DBI;
use DBD::mysql;

our %month=("Jan"=>1,
    "Feb"=>2,
    "Mar"=>3,
    "Apr"=>4,
    "May"=>5,
    "Jun"=>6,
    "Jul"=>7,
    "Aug"=>8,
    "Sep"=>9,
    "Oct"=>10,
    "Nov"=>11,
    "Dec"=>12
    );

while(my ($key,$value) = each %month)
{
    print "k = $key, v = $value\n";
}

our $global_cfg="/opt/freesvr/audit/etc/global.cfg";
our ($mysql_server,$mysql_port,$mysql_user,$mysql_pass,$mysql_db,$hostname);

our $FILE;
if(!open($FILE,"<".$global_cfg))
{
    kill 15,getppid();
    die($!.$global_cfg);
}
while(my $line=<$FILE>)
{
    chomp $line;
    my($name,$value)=split(/=/,$line);
    if($name eq "mysql-server")
    {
        $mysql_server=$value;
    }
    elsif($name eq "mysql-port")
    {
        $mysql_port=$value;
    }
    elsif($name eq "mysql-user")
    {
        $mysql_user=$value;
    }
    elsif($name eq "mysql-pass")
    {
        $mysql_pass=$value;
    }
    elsif($name eq "mysql-db")
    {
        $mysql_db=$value;
    }
    elsif($name eq "global-server")
    {
        $hostname=$value;
    }
}
close($FILE);

our $sqr;
our $dbh=DBI->connect("DBI:mysql:database=$mysql_db;host=$mysql_server;port=$mysql_port;mysql_connect_timeout=5","$mysql_user","$mysql_pass",{RaiseError=>1});
$dbh->do("set NAMES utf8");

our $vpnlog = "/var/log/vpn.log";
open (our $fd,"<",$vpnlog) or die($!);

while(my $line=<$fd>)
{
    chomp $line;

    if($line=~/\/.*MULTI_sva:/)
    {
        my ($weekday,$mon,$day,$time,$year,$user,$src_ip,$isactive,$ip)=$line=~/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\/(\S+):(\S+).*IPv4=(\S+),/;
        $mon = $month{$mon};
        my $in_time = "$year-$mon-$day $time";
=pod
        print "in_time =#$year-$mon-$day $time#
            user =#$user#
            src_ip =#$src_ip#
            isactive =#$isactive#
            ip =#$ip#
            ######################\n";
=cut
     $dbh->do("insert into vpn_log values(null, '$user', '$src_ip', '$ip' , '$in_time' ,
            null, $isactive)");
    }
    elsif($line=~/\/.*Connection\sreset/)
    {
        my ($weekday,$mon,$day,$time,$year,$user,$src_ip,$isactive)=$line=~/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\/(\S+):(\S+)\s+/;
        $mon = $month{$mon};
        my $out_time = "$year-$mon-$day $time";
=pod
        print "out_time =#$year-$mon-$day $time#
            user = #$user#
            src_ip = #$src_ip#
            isactive = #$isactive#
            ######################\n";
=cut
        $sqr = $dbh->prepare("select max(id) from vpn_log where out_time is null and user='$user' and src_ip = '$src_ip' and isactive=$isactive");
        $sqr->execute();
        my $maxid=0;
        print "select max(id) from vpn_log where out_time is null and user='$user' and src_ip = '$src_ip' and isactive=$isactive\n";
        while(my $ref = $sqr->fetchrow_hashref())
        {
            $maxid = $ref->{'max(id)'};
        }
        if($maxid>0)
        {
            $dbh->do("update vpn_log set out_time='$out_time' where id=$maxid");
        }
    }
}

`echo > /var/log/vpn.log`;
