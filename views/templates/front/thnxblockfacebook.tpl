{if $facebookurl != ''}
	<div id="fb-root"></div>
	<div id="facebook_block" class="thnxblockfacebook thnx_facebook_block block col-sm-3">
		<h4 class="title_block">{l s='Follow us on Facebook' mod='thnxblockfacebook'}</h4>
		<div class="block_content">
			<div class="facebook-fanbox">
				<div class="fb-like-box" data-href="{$facebookurl|escape:'html':'UTF-8'}" data-colorscheme="light" data-width="270"  data-show-faces="true" data-header="false" data-stream="false" data-share="false" data-show-border="false" data-adapt-container-width="true" data-small-header="false" data-layout="standard">
				</div>
			</div>
		</div>
	</div>
{/if}