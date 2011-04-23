<?xml version="1.0" encoding="UTF-8" ?>
<container xmlns="http://symfony.com/schema/dic/services"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">
    <parameters>
        <parameter key="{{ alias }}.param1">value1</parameter>
        <parameter key="{{ alias }}.param2.key1">value2-1</parameter>
        <parameter key="{{ alias }}.param2.key2">value2-2</parameter>
    </parameters>
</container>