<form method="post">
    <label><?php echo Yii::t('oauth2server.views', 'Do You Authorize {client}', array('{client}'=>$model->clientName)) ?></label><br />
    <button type="submit" name="authorized" value="yes">
        <?php echo Yii::t('oauth2server.views', 'Yes'); ?>
    </button>
    <button type="submit" name="authorized" value="no">
        <?php echo Yii::t('oauth2server.views', 'No'); ?>
    </button>
</form>