<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class midiaModel extends CI_Model
{
	public function do_insert($dados=NULL, $redir=TRUE)
	{
		if ($dados != NULL) 
		{
			$this->db->insert('midias',$dados);
			if ($this->db->affected_rows()>0)
			{	
				auditoria('Inclusão de mídia','Nova mídia cadastrada no sistema');
				set_msg('msgok','Imagem cadastrada com sucesso','sucess');
			}else{
				set_msg('msgok','Ocorreu um erro ao tentar inserir registro','error');
			}
			if($redir) redirect(current_url());
		}
	}

	public function do_update($dados=NULL, $condicao=NULL, $redir=TRUE)
	{
		if ($dados != NULL && is_array($condicao))
		{
			$this->db->update('midias',$dados,$condicao);
			if ($this->db->affected_rows()>0)
			{	
				auditoria('Alteração de mídia', 'A mídia com o id "'.$condicao['id'].'" foi alterada');
				set_msg('msgok','Alteração efetuada com sucesso','sucess');
			}else{
				set_msg('msgok','Ocorreu um erro ao tentar alterar registro','error');
			}			
			if($redir) redirect(current_url());
		}
	}

	public function do_delete($condicao=NULL,$redir=TRUE)
	{
		
		if ($condicao != NULL && is_array($condicao)) 
		{
			$this->db->delete('midias',$condicao);
			if ($this->db->affected_rows()>0)
			{
				auditoria('Exclusão de mídia', 'A mídia com o id "'.$condicao['id'].'" foi excluída');
				set_msg('msgok','Registro excluído com sucesso','sucess');
			}else{
				set_msg('msgok','Erro ao excluir registro','error');
			}
			if ($redir) redirect(current_url());
		}
		else
		{
			return FALSE;
		}
	}

	public function do_upload($campo)
	{
		$config['upload_path'] = './medias/images/uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$this->load->library('upload',$config);
		if ($this->upload->do_upload($campo)) 
		{
			return $this->upload->data();
		}else{
			return $this->upload->display_errors();
		}
	}
	
	public function get_all()
	{			
		return $this->db->get('midias');
	}

	public function get_by_id($id=NULL)
	{
		
		if ($id != NULL) 
		{
			$this->db->where('id_midia',$id);
			$this->db->limit(1);
			return $this->db->get('midias');
		}
		else
		{
			return FALSE;
		}
	}
	
}

/*
* End of file midiaModel.php
* Location: /application/models/midiaModel.php
*/