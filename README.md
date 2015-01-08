# Multisocial API
To integrate multiple social platforms into your system, we have created unified API that does those
integrations for you.

# Usage
To use this app, you need to be registered at http://multisocialapp.com

`MultisocialApi.php` represents needed functions and calls that you can use for successfull and safe data retrieval.
`index.php` is landing page, where we initialize `MultisocialApi` object and provide public/private/secret keys to it.

# Example
To see your selected platforms, just copy-paste iframe from configurations.

For test purposes and to see how easy it is to integrate, you can try including this iframe
into your page:

`<iframe src="http://multisocialapp.com/api/v1/integrate?api_key=db463d77ade315e59116456fae63ae9b" style="border: 0;"><iframe>`

If you will try to log into social platforms from this iframe you will get redirected to multisocialapp.com website. This is because this api key represents our system. 

If you liked how it works, you can register at our system and get your api key that will represent you.

Any questions or concerns? You can write to me or use our contact form http://multisocialapp.com/contact

PS - This will also work on localhost.
PSS - Project is in early beta stage. We will include more social platforms and possibility to edit how social platform buttons will look.
