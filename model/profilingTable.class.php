<?php

class profilingTable
{

    public static function getProfilings()
    {
    
        $em = dbconnection::getInstance()->getEntityManager();
        
        $profilingRepository = $em->getRepository('profiling');
        
        $profilings = $profilingRepository->findAll();
        
        if ($profilings == false)
        {
        
            return null;
        
        }
        
        return $profilings;
    
    }
    
    public static function getProfilingById($id)
    {
        
        $em = dbconnection::getInstance()->getEntityManager();
        
        $profilingRepository = $em->getRepository('profiling');
        
        $profiling = $profilingRepository->findOneBy(array(
            'id'    =>  $id
        ));
        
        if ($profiling == false)
        {
            
            return null;
            
        }
        
        return $profiling;
        
    }

}

?>