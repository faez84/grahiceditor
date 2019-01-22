<?php

namespace App\Command;

use App\Exceptions\NotFoundShapeException;
use App\Models\AbstractShape;
use App\Service\Editor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;

class EditorCommand extends Command
{
    protected static $defaultName = 'editor:draw-shapes';
    private $_shapeNameSpace = 'App\\Models';
    private $_editor;

    public function __construct(Editor $editor, string $name = null)
    {
        parent::__construct($name);
        $this->_editor = $editor;
        $this->_editor->setEnabledValidation(false);
    }

    protected function configure()
    {
        $this
            ->setDescription('Graphic Editor.')
            ->setHelp('This command allows you to create the graphic editor and add shapes to it...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        while (true) {
            $question = new ChoiceQuestion(
                'Please choose an option ',
                ['add', 'remove', 'draw', 'exit']
            );
            $option = $helper->ask($input, $output, $question);

            if (null === $option || 'exit' === $option) {
                break;
            }
            switch ($option) {
                case 'add':
                    $shapeData = $this->addShapes($input, $output, $helper);
                    $this->_editor->addShapes($shapeData);
                    break;
                case 'remove':
                    $this->removeShape($input, $output, $helper);
                    break;
                case 'draw':
                    $output->writeln('Editor output: ');
                    $output->writeln($this->_editor->drawShapes());
                    break;
            }
        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param $helper
     */
    public function removeShape(InputInterface $input, OutputInterface $output, $helper)
    {
        $question = new Question('Please shape id ? ');
        $id = $helper->ask($input, $output, $question);
        $this->_editor->removeShape($id);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param $helper
     * @return array
     * @throws NotFoundShapeException
     */
    public function addShapes(InputInterface $input, OutputInterface $output, $helper): array
    {
        $shapeData = [];
        $shapeDatum = [];
        $question = new ChoiceQuestion(
            'Please enter the shape ',
            ['circle', 'square', 'exit']
        );
        $shapeName = $helper->ask($input, $output, $question);
        $shapeClass = $this->_shapeNameSpace . '\\' . ucfirst(strtolower($shapeName));
        if (!class_exists($shapeClass)) {
            throw new NotFoundShapeException('This shape was not found');
        }
        /** @var AbstractShape $shape */
        $shape = new $shapeClass();
        $parameters = $shape->getParams();
        $params = [];
        foreach ($parameters as $parameter) {
            $question = new Question('Please enter the value of ' . $parameter . '? ');
            $parameterValue = $helper->ask($input, $output, $question);
            $params[$parameter] = $parameterValue;
        }
        $shapeDatum['type'] = $shapeName;
        $shapeDatum['params'] = $params;
        $shapeData[] = $shapeDatum;

        return $shapeData;
    }
}
