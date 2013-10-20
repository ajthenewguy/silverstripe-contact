<form $FormAttributes>
    <% if $Message %>
        <p id="{$FormName}_error" class="message $MessageType">$Message</p>
    <% else %>
        <p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
    <% end_if %>
     
	<% if $Fields %>
    <fieldset>
		<% loop $Fields %>$Field
		<div id="Email" class="field email">
		<label class="left" for="{$Top.FormName}_{$Name}">$Name</label>
            $Field
		</div>
		<% end_loop %>
        $Fields.dataFieldByName(SecurityID)
    </fieldset>
	<% end_if %>
     
    <% if $Actions %>
    <div class="Actions">
        <% loop $Actions %>$Field<% end_loop %>
    </div>
    <% end_if %>
</form>