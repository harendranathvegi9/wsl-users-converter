## WSL Social Plugins Users Converter
 
A simple [WordPress Social Login](https://wordpress.org/plugins/wordpress-social-login/) add-on. WSL Social Plugins Users Converter make WSL compatible with a selection of WordPress social plugins like Social Connect, Super socializer and LoginRadius. 

![Bouncer Setup](https://raw.githubusercontent.com/miled/wsl-users-converter/master/screenshot-1.png)

#### Install
1. Download, Unzip and drop the extension on `/wp-content/plugins/` directory,
2. As administrator, activate the plugin through the 'Plugins' menu in WordPress,
3. Navigate to **Settings > WP Social Login**, then go to the **Components** tab and enable **WSL Users Converter**.

#### Usage

After you have installed and enabled WSL Users Converter, navigate to Bouncer tab and you will find a new section where can configure what social plugins you want to make WSL compatible with.

#### Notes
1. Each social plugin have his own way of storing their users identifications, and Bouncer may not able to recognize every user.
2. Bouncer will access the other plugins identification registers in mode READ-ONLY and it won't change a thing.
3. Try to keep this list relevant. With each enabled plugin in the bow below, Bouncer will make an extra effort to query the database. 