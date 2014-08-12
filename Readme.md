# AOE SessionVars

## Description

The purpose of this module is to provide a generic way to "capture" variables coming in from outside (via url parameter or cookie) and store them in the specified session, so it can be consumed by other modules from there
Author: Manish Jain

## Installation

Please remember using the `--recursive` parameter while cloning:

    git clone --recursive https://github.com/AOEpeople/Aoe_SessionVars.git Aoe_SessionVars

The module comes with a modman configuration file.

## Usage

On every page hit incoming variable should be evaluated and validated against the regex pattern. Then stored in the session. If a value already exist in the session and a new value is being provided then the new one should overwrite the existing one.

## How it works

Add the variables in your module's config.xml which needs to be set in session
<frontend>
	<aoe_sessionvars>
		<vars>
			<var1><!-- this is the internal name of the variable that's used to store/access the value from the core/customer/checkout session -->
				<getParameterName /><!-- if empty this parameter can't be captured by url -->
				<cookieName /><!-- if empty this parameter can't be captured by cookie -->
				<validate /> <!-- Regular expression to validate the value of parameter -->
				<scope /><!-- if empty core will be used -->
			</var1>
		</vars>
	</aoe_sessionvars>
</frontend>

Example:
<frontend>
	<aoe_sessionvars>
		<vars>
			<coupon_code>
				<getParameterName>cp</getParameterName>
				<cookieName>MAGENTO_CP</cookieName>
				<validate><![CDATA[/^[^$|\s+$]/]]></validate>
				<scope>customer</scope>
			</coupon_code>
		</vars>
	</aoe_sessionvars>
</frontend>

In above example, If URL contains the parameter as 'cp' or 'MAGENTO_CP' cookie is set, value of 'cp' or 'MAGENTO_CP' will be set in specified session (scope).

It also come with a concept to easily consume the session variable in CMS blocks (or other text that's processed with the
template filters).

Example:

Click <a href="http://www.domain.com/?lang={{sessionVar code=lang}}">here</a>

<frontend>
	<aoe_sessionvars>
		<lang>
			<getParameterName>lang</getParameterName>
			<cookieName />
			<validate />
			<scope />
		</lang>
	</aoe_sessionvars>
</frontend>