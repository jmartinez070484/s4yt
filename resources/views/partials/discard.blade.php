<div class="modal-content">
	<p>Are you ready to discard?</p>
	<input type="button" value="Yes" onclick="if(question){ question.removeAnswer(); }" />
	<input type="button" value="Nope" onclick="this.parentNode.parentNode.parentNode.parentNode.clearModal()" />
</div>