# AOE SessionVars

## Description

The purpose of this module is to provide a generic way to "capture" variables coming in from outside (via url parameter or cookie) and store them in the specified session, so it can be consumed by other modules from there

## Authors/Contributors

- [Manish Jain](https://github.com/manish172)
- [Fabrizio Branca](https://github.com/fbrnc)

## Usage

On every page hit incoming variable should be evaluated and validated against the regex pattern. Then stored in the session. If a value already exist in the session and a new value is being provided then the new one should overwrite the existing one.

## How it works

Add the variables in your module's config.xml which needs to be set in session
```xml
<frontend>
	<aoe_sessionvars>
		<vars>
			<var1><!-- this is the internal name of the variable that's used to store/access the value from the core/customer/checkout session -->
				<getParameterName /><!-- if empty this parameter can't be captured by url -->
				<cookieName /><!-- if empty this parameter can't be captured by cookie -->
				<validate /> <!-- Regular expression to validate the value of parameter -->
				<scope /><!-- if empty core will be used -->
				<defaultValue /><!-- fallback if parameter wasn't captured before -->
			</var1>
		</vars>
	</aoe_sessionvars>
</frontend>
```

Example:
```xml
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
```

In above example, If URL contains the parameter as 'cp' or 'MAGENTO_CP' cookie is set, value of 'cp' or 'MAGENTO_CP' will be set in specified session (scope).

It also come with a concept to easily consume the session variable in CMS blocks (or other text that's processed with the
template filters).

Example:

Incoming request: http://www.example.com/?lang=en-ca&country=ca

CMS content: Click <a href="http://www.domain.com/{{sessionVar code=country}}/?lang={{sessionVar code=lang}}">here</a>

```xml
<frontend>
	<aoe_sessionvars>
		<country>
			<getParameterName>country</getParameterName>
			<cookieName />
			<validate><![CDATA[/^[A-Za-z]{2}$/]]></validate>
			<scope />
			<defaultValue>en</defaultValue>
		</country>
		<lang>
			<getParameterName>lang</getParameterName>
			<cookieName />
			<validate><![CDATA[/^([A-Za-z]{2})-([A-Za-z]{2})$/]]></validate>
			<scope />
			<defaultValue>en-us</defaultValue>
		</lang>
	</aoe_sessionvars>
</frontend>
```