**To decide**

Add to to the library the form open tag. We have two options here. We either load the form helper from ci and use <?= form_open() ?> or we can just declare the html. *User should also be able to decide if the form open/close tags are needed in output*

I think we should just add a setting for the user to choose that. This way if people want to use the helper (to add the security token and whatnot) they can. If they don't need that, they can just leave it with the default value. Normal html form open.

Do we have access to the !null option to that field? Because if we do we can add by default the required="required" param. *AFAIR no, would have to check*
