# Magento 2 Facebook Login Extension

The Collab_FacebookLogin gives customers the ability to sign in to your website quickly and securely
using their Facebook account. It is a secure and easy way to log in to your website without the need
to remember a password. Module utilizes [Collab_CustomerPasswordLessLogin](https://github.com/collabpl/magento2-module-customer-passwordless-login)
module to create an account or login the user without the need of a password.

Initially module adds the button to the login form only. It is possible to add the button to any other place
by following the instructions in the [Basic usage](#basic-usage) section.


## Why choose this extension over other solutions?
We don't believe in efficient modules which have tons of options - simple as that - modules which have multiple
options, are prepared for many integrations always have some performance footprint for application. Having this
in mind we are trying to provide simple, portable and independent modules which require some basic Magento 2 development
skills.


## PageSpeed
This module shoudn't by any means impact Your PageSpeed score. Module is not embedding any external scripts or styles 
which can impact main thread.


## Prerequistes
- `client_id` for Your FB app
- `client_secret` for Your FB app
- once `client_id` and `client_secret` are generated and obtained they need to be set up at Magento in Stores -> Configuration -> Collab Extensions -> Facebook Login


## Basic usage
You can add the button to any place in the layout by referencing desired block/container:
```xml
<referenceContainer name="DESIRED_CONTAINER_NAME">
    <block name="collab.facebooklogin.button"
           template="Collab_FacebookLogin::button/fb.phtml"
           before="-"
           ifconfig="collab_facebooklogin/general/enabled">
        <arguments>
            <argument name="fb_login_config" xsi:type="object">
                Collab\FacebookLogin\ViewModel\FacebookLoginConfig
            </argument>
        </arguments>
    </block>
</referenceContainer>
```


## Installation details
```bash
composer req collab/module-facebook-login
bin/magento setup:upgrade
```
