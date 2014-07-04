<?php

namespace Paco\Bundle\FollowableBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use InvalidArgumentException;
use Doctrine\ORM\Query\ResultSetMapping;


/**
 * This command class import inside your database required table for this bundle to work
 *
 * @author GUEYE Mamadou <papepapes@gmail.com>
 */
class ImportBehaviorSQLTableCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
        ->setName('paco:followable:create-table')
        ->setDescription('Create the followable behavior required table.')
        ->addOption('dump-sql', null, InputOption::VALUE_OPTIONAL, 'Display the SQL this bundle trun against your database.')
        ->setHelp(<<<EOT
            The <info>paco:followable:create-table</info> command creates the joint table used to setup the many-to-many relationship:

            <info>php app/console paco:followable:create-table</info>


            You can also optionally tell this command to dump the SQL it runs on your database:

            <info>php app/console paco:followable:create-table --dump-sql</info>

            <error>Be careful: this command drop the joint table if it exists before creating it.</error>
            EOT
            );
}

protected function execute(InputInterface $input, OutputInterface $output)
{
    $rsm = new ResultSetMapping();
    $em = $this->getContainer()->get('doctrine')->getManager();
    $users_table_name = $this->getContainer()->getParameter('users_table_name');
    $followable_id_attribute_name = $this->getContainer()->getParameter('followable_id_attribute_name');
    $joint_table_name = $this->getContainer()->getParameter('joint_table_name');
    $joint_table_follower_column_name = $this->getContainer()->getParameter('joint_table_follower_column_name');
    $joint_table_followee_column_name = $this->getContainer()->getParameter('joint_table_followee_column_name');
    $sql = '<<<EOT 
    --
    -- Structure de la table `follows`
    --

    DROP TABLE IF EXISTS `'.$joint_table_name.'`;
    CREATE TABLE IF NOT EXISTS `follows` (
      `'.$joint_table_follower_column_name.'` int(11) NOT NULL,
      `'.$joint_table_followee_column_name.'` int(11) NOT NULL,
      KEY `'.$joint_table_follower_column_name.'` (`'.$joint_table_follower_column_name.'`),
      KEY `'.$joint_table_followee_column_name.'` (`'.$joint_table_followee_column_name.'`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `follows`
--
ALTER TABLE `follows`
ADD CONSTRAINT `followee_user_fk` FOREIGN KEY (`'.$joint_table_followee_column_name.'`) REFERENCES `'.$users_table_name.'` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `follower_user_fk` FOREIGN KEY (`'.$joint_table_follower_column_name.'`) REFERENCES `'.$users_table_name.'` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

EOT        
';
$cnx = $em->getConnection();
$cnx->exec($sql);
if($input->hasOption('dump-sql')){
    $output->writeln($sql);
}

}
}
