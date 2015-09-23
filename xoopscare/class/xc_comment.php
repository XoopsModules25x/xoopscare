<?php
/**
 * ****************************************************************************
 * XOOPSCARE - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}


include_once XOOPS_ROOT_PATH.'/kernel/comment.php';
/**
 * XOOPS comment handler class.
 *
 * This class is responsible for providing data access mechanisms to the data source
 * of XOOPS comment class objects.
 *
 *
 * @package     kernel
 * @subpackage  comment
 *
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class XoopscareXoopsCommentHandler extends XoopsCommentHandler
{

   /**
     * Write a comment to database
     *
     * @param   object  &$comment
     *
     * @return  bool
     **/
    function insert(&$comment)
    {
        if (!$comment->isDirty()) {
            return true;
        }
        if (!$comment->cleanVars()) {
            return false;
        }
        foreach ($comment->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        if ($comment->isNew()) {
            $com_id = $this->db->genId('xoopscomments_com_id_seq');
            $sql = sprintf("INSERT INTO %s (com_id, com_pid, com_modid, com_icon, com_title, com_text, com_created, com_modified, com_uid, com_ip, com_sig, com_itemid, com_rootid, com_status, com_exparams, dohtml, dosmiley, doxcode, doimage, dobr) VALUES (%u, %u, %u, %s, %s, %s, %u, %u, %u, %s, %u, %u, %u, %u, %s, %u, %u, %u, %u, %u)", $this->db->prefix('xoopscomments'), $com_id, $com_pid, $com_modid, $this->db->quoteString($com_icon), $this->db->quoteString($com_title), $this->db->quoteString($com_text), $com_created, $com_modified, $com_uid, $this->db->quoteString($com_ip), $com_sig, $com_itemid, $com_rootid, $com_status, $this->db->quoteString($com_exparams), $dohtml, $dosmiley, $doxcode, $doimage, $dobr);
        } else {
            $sql = sprintf("UPDATE %s SET com_pid = %u, com_icon = %s, com_title = %s, com_text = %s, com_created = %u, com_modified = %u, com_uid = %u, com_ip = %s, com_sig = %u, com_itemid = %u, com_rootid = %u, com_status = %u, com_exparams = %s, dohtml = %u, dosmiley = %u, doxcode = %u, doimage = %u, dobr = %u WHERE com_id = %u", $this->db->prefix('xoopscomments'), $com_pid, $this->db->quoteString($com_icon), $this->db->quoteString($com_title), $this->db->quoteString($com_text), $com_created, $com_modified, $com_uid, $this->db->quoteString($com_ip), $com_sig, $com_itemid, $com_rootid, $com_status, $this->db->quoteString($com_exparams), $dohtml, $dosmiley, $doxcode, $doimage, $dobr, $com_id);
        }
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        if (empty($com_id)) {
            $com_id = $this->db->getInsertId();
        }
        $comment->assignVar('com_id', $com_id);
        return true;
    }

    /**
     * Delete a {@link XoopsComment} from the database
     *
     * @param   object  &$comment
     *
     * @return  bool
     **/
    function delete(&$comment)
    {
        if (strtolower(get_class($comment)) != 'xoopscomment') {
            return false;
        }
        $sql = sprintf("DELETE FROM %s WHERE com_id = %u", $this->db->prefix('xoopscomments'), $comment->getVar('com_id'));
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        return true;
    }

}
?>