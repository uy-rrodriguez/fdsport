<?php

class profilingTable
{

    public static function getProfilings()
    {
    
        $em = dbconnection::getInstance()->getEntityManager();
        
        $profilingRepository = $em->getRepository('profiling');
        
        $profilings = $profilingRepository->findAll();
        
        if ($profilings === false)
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

    public static function save(profiling $profiling)
    {
        $em = dbconnection::getInstance()->getEntityManager();

        if (! $profiling->id) {
            $profiling->id = null;
            $em->persist($profiling);
        }
        else {
            $em->merge($profiling);
        }

        $em->flush();
    }

    public static function deleteAll()
    {
        $em = dbconnection::getInstance()->getEntityManager();
        $q = $em->createQuery('DELETE FROM profiling');
        return $q->execute();
    }

}

?>