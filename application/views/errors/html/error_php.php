<div style="border:1px solid #990000;padding:10px 20px;margin:0 0 10px 0;font-family:'DM Sans',sans-serif;font-size:14px;background:#fef2f2;color:#292524;border-radius:8px;">
    <h4 style="color:#dc2626;margin:0 0 8px;">A PHP Error was encountered</h4>
    <p><strong>Severity:</strong> <?php echo $severity; ?></p>
    <p><strong>Message:</strong> <?php echo $message; ?></p>
    <p><strong>Filename:</strong> <?php echo $filepath; ?></p>
    <p><strong>Line Number:</strong> <?php echo $line; ?></p>
    <?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>
        <p><strong>Backtrace:</strong></p>
        <?php foreach (debug_backtrace() as $error): ?>
            <?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>
                <p style="margin-left:10px;font-size:12px;">
                    File: <?php echo $error['file']; ?><br>
                    Line: <?php echo $error['line']; ?><br>
                    Function: <?php echo $error['function']; ?>
                </p>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
