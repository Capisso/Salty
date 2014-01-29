Salty [![Build Status](https://travis-ci.org/Capisso/Salty.png?branch=master)](https://travis-ci.org/Capisso/Salty)
=====

A Salt Rest API interface for Laravelish projects.

Quick Usage:

    $uptime = Salty::against('*')->module('status')->uptime()->getResults(true);
