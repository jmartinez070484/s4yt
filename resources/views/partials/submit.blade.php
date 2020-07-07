<div class="modal-content">
	<p>Are you ready to submit?</p>
	<input type="button" value="Yes" onclick="if(question){ question.submitForm('thanks',true); }" />
	<input type="button" value="Nope" onclick="this.parentNode.parentNode.parentNode.parentNode.clearModal()" />
</div>